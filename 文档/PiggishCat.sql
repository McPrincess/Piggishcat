--  1 : 客户用户表
	create table if not exists `pc_client`( 
	`clt_id` int unsigned not null auto_increment,
	primary key(`clt_id`) comment'客户id',
	`clt_user` varchar(64) unique not null comment'用户名,登录依据1',
	`clt_phone`  char(11) unique not null comment'用户手机,登录依据2',
	`clt_pass` varchar(255) not null comment'用户密码',
	`clt_paypass` varchar(255) not null default'' comment'支付密码',
	`clt_sex` tinyint unsigned not null default 2 comment'0:male 1:female 2:confidentiality',
	`clt_realname` varchar(64) not null  default'' comment'真实姓名',
	`clt_identity` char(18) unique not null default '' comment'身份证号码',
	`clt_moeny` float(10,2) unsigned not null default 0 comment'用户余额',
	`clt_spending` float unsigned not null default 0 comment'消费金额 : 0-1000:青铜 , 1001-5000:白银 , 5001-2000:黄金 , 20001-100000:白金 , >100000:钻石'
)engine=innodb default charset=utf8;

--  2 : 地址表 
	create table if not exists `pc_address`(
			`ads_id` int unsigned unique not null auto_increment,
			primary key(`ads_id`) comment'地址ID',
			`clt_id` int unsigned not null comment'用户ID',
			`clt_name` varchar(64) not null comment'联系人姓名',
			`clt_phone` char(11)  not null comment'联系方式',
			`clt_address` varchar(128) not null  comment'收件地址'
		)engine=innodb default charset=utf8;

--  3 : 管理员用户表
	create table if not exists `pc_admin`(
			`adn_id` int unsigned unique not null auto_increment,
			primary key(`adn_id`) comment'管理员id',
			`adn_user` varchar(64) unique not null comment'管理员帐号',
			`adn_pass` varchar(255) not null comment'管理员密码',
			`adn_name` varchar(64)  unique not null comment'管理员姓名',
			`adn_phone` char(11) unique not null comment '管理员联系方式',
			`adn_identity` char(18) unique not null comment'管理员身份证',
			`adn_grade` tinyint unsigned  not null default 1 comment'权限 : 0 : 超管 1 : 渣渣管理',
			`adn_addtime` int unsigned not null comment'添加时间'
		)engine=innodb default charset=utf8;

--  4 : 商家用户表
		create table if not exists `pc_shopUser`(
			`shr_id` int unsigned unique not null auto_increment,
			primary key(`shr_id`) comment'商家用户id',
			`shr_user` varchar(64) unique not null comment'商户帐号,登录依据',
			`shr_pass` varchar(255) not null comment'密码',
			`shr_sex` tinyint unsigned not null default 2 comment'性别 : 0:male 1:female 2:confidentiality',
			`shr_phone` char(11) unique not null comment'手机',
			`shr_realname` varchar(64)  not null comment'真实姓名',
			`shr_identity` char(18) unique not null comment'身份证号码',
			`shr_addtime` int unsigned not null comment'商户创建时间'
		)engine=innodb default charset=utf8;
 
--  5 : 店铺表
		create table if not exists `pc_shop`(
			`shp_id` int unsigned unique not null auto_increment,
			primary key(`shp_id`) comment'店铺id',
			`shr_id` int unsigned unique not null comment'父级id',
			`shp_name` varchar(64) unique not null comment'店铺名',
			`shp_money` int unsigned not null comment'保证金',
			`shp_addtime` int unsigned not null default 0 comment'开店时间',
			`shp_status` tinyint unsigned not null default 0  comment'状态 : 0 待审核 ; 1 可营业 ; 2 整顿中'
		)engine=innodb default charset=utf8;

--  6 : 商品分类表
	create table if not exists `pc_Category`(
			`goy_id` int unsigned unique not null auto_increment,
			primary key(`goy_id`) comment'商品分类id',
			`goy_name` varchar(64) unique  not null comment'分类名称',
			`goy_pid` int unsigned not null default 0 comment'所属分类id',
			`goy_path` varchar(10)  not null default '0,' comment'分类级别'
		)engine=innodb default charset=utf8;



--  7 : 商品信息表
	create table if not exists `pc_goods`(
		 	`gos_id` int unsigned unique not null auto_increment,
		 	primary key(`gos_id`) comment'商品ID',
		 	`gos_name` varchar(255) unique not null,
		 	unique (`gos_name`) comment'商品名称',
		 	`goy_id` int unsigned not null comment'所属分类ID',
		 	`gos_description` varchar(255) not null  default'' comment'商品描述',
		 	`gos_price` float(7,2) unsigned not null comment'单价',
		 	`gos_sales` int unsigned not null default 0 comment'销量',
		 	`gos_inventory` int unsigned not null default 0 comment'库存',
		 	`gos_view` int unsigned not null default 0 comment'浏览量',
		 	`gos_status` tinyint unsigned not null default 0 comment'状态 : 0=待审核 , 1=审核通过已上架 2=下架',
		 	`gos_addtime` int unsigned not null comment'添加时间'
	 )engine=innodb default charset=utf8;

-- 8 : 商品图片表
	create table if not exists `pc_goodsPicture`(
		`goe_id` int unsigned not null auto_increment,
		primary key(`goe_id`) comment '商品图片主键',
		`gos_id` int unsigned not null comment'所属商品ID',
		`goe_name` varchar(255) not null  comment'商品名称',
		`goe_path` varchar(128) not null comment'图片路径信息',
		`goe_status` tinyint not null default 0 comment'图片状态 0=禁用 1=启用'
	)engine=innodb default charset=utf8;

-- 9 : 购物车表
	
	create table if not exists `pc_shoppingcart`(
		`sht_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		PRIMARY KEY (`sht_id`) COMMENT '购物车id',
		`clt_id` int(10) unsigned NOT NULL COMMENT '用户ID',
		`gos_id` int(10) unsigned NOT NULL COMMENT '商品id',
		`gos_name` varchar(255) NOT NULL COMMENT '商品名称',
		`gos_price` float(8,2) NOT NULL COMMENT '商品单价',
		`sht_num` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '购买商品数量',
		`sht_addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间'

	) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;



-- 10 : 订单表
	create table if not exists `pc_orderForm`(
		`orm_id` int unsigned not null auto_increment,
		primary key(`orm_id`) comment '商品主键',
		`clt_id` int unsigned not null comment '用户ID',
		`gos_id` int unsigned not null comment '商品id',
		`ads_id` int unsigned not null comment'地址id',
		`orm_quantity` int unsigned not null comment '数量',
		`orm_total` float not null comment '订单总价',
		`orm_addtime` int unsigned not null comment '下单时间',
		`orm_status` tinyint unsigned  not null defalult 0 comment '0:新订单,1:已发货,2:已签收,3:交易完成',
		`orm_evestatus` tinyint unsigned not null default 0 comment '0:未评价,1:已评价'
	)engine=innodb default charset=utf8;

	insert into `pc_orderForm`(`orm_id`,`clt_id`,`gos_id`,`ads_id`,`orm_quantity`,`orm_total`,`orm_addtime`,`orm_status`,`orm_evestatus`) 
		values('1','1','12','2','100','9998',unix_timestamp(),0,0);
		


-- 11 : 收藏表
	create table if not exists `pc_ enshrine`(
		`ene_id` int unsigned not null auto_increment,
		primary key(`ene_id`) comment '收藏id',
		`clt_id` int unsigned not null comment '用户ID',
		`sge_id` int unsigned not null comment '店铺/商品id',
		`ene_type` tinyint unsigned not null default 1 comment '0:店铺,1:商品',
		`ene_addtime` int unsigned default 0 not null comment'收藏时间'
	)engine=innodb default charset=utf8;

-- 12 : 浏览记录表
  create table if not exists `pc_footprint`(
      `fot_id` int unsigned not null auto_increment,
      primary key(`fot_id`) comment '足迹id',
      `clt_id` int unsigned not null   comment '用户id',
      `gos_id` int  unsigned not null   comment '商品id',
      `fot_addtime` int unsigned not null default 0 comment '浏览时间'
    )engine=innodb default charset=utf8;

-- 13 : 商品退换表
  create table if not exists `pc_salesReturn`(
      `san_id` int unsigned not null auto_increment,
      primary key(`san_id`) comment '退换单id',
      `clt_id` int unsigned not null   comment '用户id',
      `orm_id` int unsigned not null   comment '订单id',
      `san_addtime` int unsigned not null default 0 comment '申请时间',
      `san_status` tinyint unsigned not null default 0 comment '状态 : 0:等待商家同意 , 1:已完成协商,准备货物返还 , 2:商家已签收 , 3:退换货完成 , 4:拒绝退换货',
      `san_news` varchar(255) not null default "" comment '拒绝退换货原因(状态为4时可用)'
    )engine=innodb default charset=utf8;

-- 14 : 商品评价表
  create table if not exists `pc_evaluate`(
      `eve_id` int unsigned not null auto_increment,
      primary key(`eve_id`) comment '商品评价id',
      `clt_id` int unsigned not null   comment '用户id',
      `orm_id` int unsigned not null   comment '订单id',
      `eve_grade` tinyint unsigned not null default 5 comment '评价等级 : 0-1:差评 , 2-3:中评 , 4-5:好评',
      `eve_detail` varchar(255) not null  default "系统默认好评!" comment '评价内容',
      `eve_addtime` int unsigned not null  default 0 comment '评价时间'
    )engine=innodb default charset=utf8;

-- 15 : 消息表
  create table if not exists `pc_news`(
      `nes_id` int unsigned not null auto_increment,
      primary key(`nes_id`) comment '消息id',
      `clt_id` int unsigned not null   comment '客户id',
      `shr_id` int unsigned not null   comment '商户id',
      `nes_detail` varchar(255) not null  comment '消息内容',
      `nes_time` int unsigned not null  comment '发送时间',
      `nes_status` tinyint unsigned not null default 0 comment '状态 : 0:客=>商 , 1:商=>客'
    )engine=innodb default charset=utf8;

-- 16 : 公告
  create table if not exists `pc_bulletin`(
      `bun_id` int unsigned not null auto_increment,
      primary key(`bun_id`) comment '公告id',
      `bun_detail` varchar(255) not null comment '公告内容',
      `bun_addtime` int unsigned not null comment '发布时间',
      `bun_chained` varchar(255) unsigned not null default "" comment '详情连接',
      `bun_status` tinyint unsigned not null comment '公告状态'
    )engine=innodb default charset=utf8;

-- 17 : 友情链接
  create table if not exists `pc_blogroll`(
      `bll_id` int unsigned not null auto_increment,
      primary key(`bll_id`) comment '链接id',
      `bll_name` varchar(255) not null  comment '链接名称',
      `bll_address` varchar(255) not null  comment '链接地址',
      `bll_addtime` int  unsigned not null comment'添加时间',
      `bll_status` tinyint unsigned not null comment '链接状态: 1=可发布 ; 2=预发布'
    )engine=innodb default charset=utf8;

--  : 留言表
  create table if not exists `pc_message`(
      `mee_id` int unsigned not null auto_increment,
      primary key(`mee_id`) comment '留言id',
      `clt_id` int not null  comment '用户id',
      `mee_detail` varchar(255) not null  comment '留言内容',
      `mee_status` tinyint not null default 1 comment '留言内容',
      `mee_addtime` int(10)  unsigned not null comment'留言时间'
    )engine=innodb default charset=utf8;

--  : 回复表
  create table if not exists `pc_reply`(
      `rey_id` int unsigned not null auto_increment,
      primary key(`rey_id`) comment '回复id',
      `clt_id` int not null  comment '用户id',
      `mee_id` int not null  comment '留言id',
      `adn_id` int not null  comment '管理员id',
      `rey_detail` varchar(255) not null  comment '回复内容',
      `rey_addtime` int  unsigned not null comment'回复时间'
    )engine=innodb default charset=utf8;




