delimiter //

DROP TRIGGER IF EXISTS BeforeInsertPurchase //

CREATE trigger BeforeInsertPurchase BEFORE INSERT ON PURCHASES FOR EACH ROW
  BEGIN
    DECLARE num int;
    select qoh into num  from products where pid = NEW.pid;
    IF NEW.qty > num or NEW.qty <= 0 THEN
--     如果购买数量超过库存，或者购买数量小于等于0，则抛出错误，停止执行
      signal sqlstate '45000';
    END IF;
  END //



DROP TRIGGER IF EXISTS AfterInsertPurchase //
CREATE trigger AfterInsertPurchase AFTER INSERT ON PURCHASES FOR EACH ROW
  BEGIN
  declare threshold int;
  declare remain int; -- 库存
  declare current_t TIMESTAMP; -- 当前时间
  declare old_visit_made int;
  select CURRENT_TIMESTAMP() into current_t; -- 读取当前时间
  -- 生成日志
  insert into logs (who, time, table_name, operation, key_value) values (NEW.eid, current_t,'PURCHASES','INSERT',NEW.pur);
  select qoh_threshold into threshold from products where pid = NEW.pid;
  select qoh into remain from products where pid = NEW.pid;
  -- 更改产品的库存信息，这里的购买数量一定是合法的，非法的购买数量已经在 Before 的触发器过滤掉了
  update products set qoh = remain - NEW.qty where pid = NEW.pid;
  select visits_made into old_visit_made from customers where cid = NEW.cid;
  set old_visit_made = old_visit_made + 1;
  -- 更新用户表，这里只更细了 visit made，没有更新访问时间，访问时间在后面用户表相关的触发器中更新
  update customers set visits_made = old_visit_made where cid = NEW.cid;
  END //




DROP TRIGGER IF EXISTS BeforeUpdateProduct //
CREATE trigger BeforeUpdateProduct BEFORE UPDATE ON PRODUCTS FOR EACH ROW
  BEGIN
    IF NEW.qoh < NEW.qoh_threshold THEN
--       当库存小于阈值，则要进货，使得库存为两倍原库存，则这里设置库存为两倍原库存即可。
      set NEW.qoh = 2 * OLD.qoh;
    END IF;
  END //




DROP TRIGGER IF EXISTS AfterUpdateProduct //
CREATE trigger AfterUpdateProduct AFTER UPDATE ON PRODUCTS FOR EACH ROW
  BEGIN
  declare current_t TIMESTAMP;
  select CURRENT_TIMESTAMP() into current_t;
--   生成记录，默认为管理员 e00 操作
  insert into logs (who,time, table_name, operation, key_value) values ('e00' ,current_t,'PRODUCTS','UPDATE',NEW.pid);
  END //



DROP TRIGGER IF EXISTS BeforeUpdateCustomer //
CREATE trigger BeforeUpdateCustomer BEFORE UPDATE ON CUSTOMERS FOR EACH ROW
  BEGIN
  declare current_t TIMESTAMP;
  select CURRENT_TIMESTAMP() into current_t;
--   更新最近访问时间
  set NEW.last_visit_time = current_t;
--   生成日志
  insert into logs (who,time, table_name, operation, key_value) values (NEW.cid,current_t,'CUSTOMERS','UPDATE',NEW.cid);
  END //
delimiter ;
