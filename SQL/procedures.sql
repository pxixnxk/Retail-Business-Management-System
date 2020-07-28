DROP PROCEDURE IF EXISTS show_table;
DELIMITER //
-- Show the data in given table.
CREATE  PROCEDURE `show_table`(IN tab_name VARCHAR(40) )
BEGIN
-- Join the table name into the search statement
 SET @t1 =CONCAT('SELECT * FROM ',tab_name );
 PREPARE stmt3 FROM @t1;
 EXECUTE stmt3;
 DEALLOCATE PREPARE stmt3;
END //
DELIMITER ;


DROP PROCEDURE IF EXISTS report_monthly_sale;
DELIMITER //
-- Show monthly sale report for given product.
CREATE PROCEDURE report_monthly_sale(IN product_name VARCHAR(40))
BEGIN
-- Make the sql statement
  SET @t1 := CONCAT('SELECT pro.pid as id,',
  'pro.pname as name, DATE_FORMAT(pur.ptime,''%b'') as month, year(pur.ptime) as year,', -- 使用 DATE_FORMAT 格式化月份
  'sum(pur.qty)as quantity,  sum(pur.total_price) as total_price,',
  'sum(pur.total_price) / sum(pur.qty) as average_price FROM purchases pur,products pro where pro.pname like "%', product_name,
--   以产品名进行模糊搜索，使用 like 匹配
  '%" and pro.pid = pur.pid group by month(pur.ptime),year(pur.ptime) order by year(pur.ptime)');
  PREPARE stmt3 FROM @t1;
  EXECUTE stmt3;
  DEALLOCATE PREPARE stmt3;
END //
DELIMITER ;


DROP PROCEDURE IF EXISTS add_purchases;
DELIMITER //
-- Add a tuple to the purchase table
CREATE PROCEDURE add_purchases(IN pur_no varchar(10),IN c_id varchar(10),IN e_id varchar(10),IN p_id varchar(10), IN quantity INT)
BEGIN
  DECLARE current_t timestamp;
  DECLARE price double;
--   生成时间戳
  SELECT CURRENT_TIMESTAMP() into current_t;
--   计算产品价格
  SELECT (original_price)*(1 - discnt_rate)into price from products where pid = p_id;
  SET price = price * quantity;
--   将得到的数据插入表中
  INSERT INTO purchases (pur, cid, eid, pid, qty, ptime, total_price) values (pur_no,c_id,e_id,p_id,quantity,current_t,price);
END //
DELIMITER ;


-- Add a tuple to the product table
DROP PROCEDURE IF EXISTS add_product;
DELIMITER //
CREATE PROCEDURE add_product(IN pid varchar(10) ,IN pname varchar(10),IN qoh int,IN qoh_threshold int,IN original_price double,IN discnt_rate double, IN sid varchar(10) )
BEGIN
  insert into products (pid, pname, qoh, qoh_threshold, original_price, discnt_rate, sid) values (pid,pname,qoh,qoh_threshold,original_price,discnt_rate,sid);
END //
DELIMITER ;


