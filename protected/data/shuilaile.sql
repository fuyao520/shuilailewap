drop table if exists activity;

drop table if exists ad_area;

drop table if exists ad_list;

drop table if exists cart;

drop table if exists collector;

drop table if exists comment_list;

drop table if exists company;

drop table if exists company_ad;

drop table if exists company_flink;

drop table if exists company_user_list;

drop table if exists company_user_points;

drop table if exists company_water;

drop table if exists coupons;

drop table if exists cservice;

drop table if exists cservice_aclog;

drop table if exists cservice_group;

drop table if exists cservice_group_role;

drop table if exists cservice_role;

drop table if exists cservice_role_authority;

drop table if exists cservice_roles;

drop table if exists exchange_code;

drop table if exists exchange_goods;

drop table if exists flink;

drop table if exists group_goods;

drop table if exists info_category;

drop table if exists info_info_relation;

drop table if exists info_special;

drop table if exists info_special_relation;

drop table if exists linkage;

drop table if exists linkage_type;

drop table if exists model;

drop table if exists model_field;

drop table if exists nlink;

drop table if exists order_goods;

drop table if exists pm_list;

drop table if exists pm_read;

drop table if exists recommend;

drop table if exists recv_address;

drop table if exists resource_list;

drop table if exists rewrite;

drop table if exists shipping;

drop table if exists site_seo;

drop table if exists tag;

drop table if exists tag_cate;

drop table if exists tbk_goods_link;

drop table if exists templates_desc;

drop table if exists user_collect;

drop table if exists user_extern;

drop table if exists user_fans;

drop table if exists user_group;

drop table if exists user_list;

drop table if exists user_login;

drop table if exists user_order;

drop table if exists user_pay;

drop table if exists user_points;

drop table if exists user_star;

drop table if exists user_thirdpassport;

drop table if exists user_visit_history;

drop table if exists vote_data;

drop table if exists vote_option;

drop table if exists vote_subject;

drop table if exists wechat_user;

/*==============================================================*/
/* Table: activity                                              */
/*==============================================================*/
create table activity
(
   activity_id          smallint(5) unsigned not null auto_increment comment '优惠活动的自增id',
   activity_name        varchar(255) not null default '' comment '优惠活动的活动名称',
   start_time           int(10) unsigned not null default 0 comment '活动的开始时间',
   end_time             int(10) unsigned not null default 0 comment '活动的结束时间',
   user_rank            int(11) not null default 0 comment '可以参加活动的用户信息，0=非会员，1=会员；2=所有',
   act_range            tinyint(3) unsigned not null default 0 comment '优惠范围；0，全部商品；1，按分类；2，按品牌；3，按商品',
   act_range_ext        varchar(255) not null comment '根据优惠活动范围的不同，该处意义不同；但是都是优惠范围的约束；如，如果是商品，该处是商品的id，如果是品牌，该处是品牌的id',
   min_amount           decimal(10,2) unsigned not null default 0 comment '订单达到金额下限，才参加活动',
   max_amount           decimal(10,2) unsigned not null default 0 comment '参加活动的订单金额下限，0，表示没有上限',
   act_type             tinyint(3) unsigned not null default 0 comment '参加活动的优惠方式；0，减免现金；1，价格打折优惠',
   act_type_ext         decimal(10,2) unsigned not null default 0 comment '如果是送赠品，该处是允许的最大数量，0，无数量限制；现今减免，则是减免金额，单位元；打折，是折扣值，100算，8折就是80',
   gift                 text not null comment '如果有特惠商品，这里是序列化后的特惠商品的id,name,price信息;取值于ecs_goods的goods_id，goods_name，价格是添加活动时填写的',
   sort_order           tinyint(3) unsigned not null default 0 comment '活动在优惠活动页面显示的先后顺序，数字越大越靠后',
   primary key (activity_id)
)
ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC comment='优惠活动的配置信息，优惠活动包括送礼，减免，打折' auto_increment=5;

alter table activity comment '优惠活动';

/*==============================================================*/
/* Table: ad_area                                               */
/*==============================================================*/
create table ad_area
(
   area_id              int(11) unsigned not null auto_increment comment 'area_id',
   area_name            varchar(255) not null default '' comment '位置名称',
   primary key (area_id)
)
engine=myisam default charset=utf8 auto_increment=100;

alter table ad_area comment '广告-位置';

/*==============================================================*/
/* Table: ad_list                                               */
/*==============================================================*/
create table ad_list
(
   ad_id                int(11) unsigned not null auto_increment comment 'ad_id',
   area_id              int(11) not null default 0 comment '广告位',
   city_id              int(11) not null default 0 comment '城市ID',
   show_type            int(11) not null default 0 comment '展现方式, 0=代码,1=文字,2=图片,3=flash',
   ad_title             varchar(255) not null default '' comment '广告标题',
   ad_words             varchar(255) not null default '' comment '文字',
   ad_img               text not null default '' comment '图片URL',
   ad_url               text not null default '' comment '广告URL',
   url_cate_id          int(11) not null default 0 comment '分类作为url',
   words_setting        text not null default '' comment '文字格式，加粗，颜色，倾斜，下划线，json格式',
   ad_code              text not null default '' comment '广告代码',
   start_date           int(11) not null default 0 comment '生效时间',
   expire_date          int(11) not null default 0 comment '到期时间',
   create_date          int(11) not null default 0 comment '创建时间',
   ad_order             int(11) not null default 0 comment '广告排序',
   primary key (ad_id)
)
engine=myisam default charset=utf8;

alter table ad_list comment '广告';

/*==============================================================*/
/* Table: cart                                                  */
/*==============================================================*/
create table cart
(
   cart_id              int(11) not null auto_increment comment '自增id',
   uid                  int(11) not null default 0 comment '用户id',
   sessionid            varchar(50) not null default '' comment '游客会话id，游客的购物车识别',
   goods_id             int(11) not null default 0 comment '商品ID',
   goods_total          int(11) not null default 0 comment '商品数量',
   goods_attr           text not null default '' comment '商品属性(json格式)',
   create_time          int(11) not null default 0 comment '创建时间',
   primary key (cart_id)
)
engine=myisam default charset=utf8;

alter table cart comment '购物车';

/*==============================================================*/
/* Table: collector                                             */
/*==============================================================*/
create table collector
(
   id                   int(11) unsigned not null auto_increment comment 'id',
   model_table          varchar(50) not null default '' comment '模型表',
   name                 varchar(200) not null default '' comment '名字',
   cate_id              int(11) unsigned not null default 0 comment '栏目分类',
   product_cate_id      int(11) unsigned not null default 0 comment '商品分类',
   keywords             varchar(50) not null default '' comment '采集关键词',
   create_time          int(11) unsigned not null default 0 comment '创建时间',
   mark                 varchar(100) not null default '' comment '备注',
   runtimes             int(11) unsigned not null default 0 comment '运行次数',
   totals               int(11) unsigned not null default 0 comment '采集总数量',
   displayorder         int(11) unsigned not null default 0 comment '显示顺序',
   last_time            int(11) unsigned not null comment '最后一次运行时间',
   pageurl              varchar(255) not null default '' comment '分页url',
   detailurl            varchar(255) not null default '' comment '内容页url(或第几个元素)',
   list_title           varchar(255) not null default '' comment '标题第几个元素',
   pagenums             int(11) unsigned not null default 0 comment '页数',
   nowpage              int(11) unsigned not null default 0 comment '当前采集到第几页',
   collect_type         int(11) unsigned not null default 0 comment '采集标识类型',
   collect_id           int(11) unsigned not null default 0 comment '采集标识第几个元素',
   list_rule            varchar(255) not null default '' comment '列表页正则',
   detail_rule          text default '' comment '内容页正则(json格式)',
   primary key (id)
);

alter table collector comment '采集器';

/*==============================================================*/
/* Table: comment_list                                          */
/*==============================================================*/
create table comment_list
(
   comment_id           int(11) unsigned not null auto_increment comment '评论ID',
   pid                  int(11) not null default 0 comment '上级评论id',
   fromid               varchar(100) not null default '' comment '最好用 表名-ID 标识',
   comment              text not null default '' comment '评论内容',
   uid                  int(11) not null default 0 comment '评论者id',
   uname                varchar(20) not null default '0' comment '评论者昵称',
   ischeck              int(11) not null default 0 comment '审核状态，1：审核成功；2：审核失败',
   create_date          int(11) not null default 0 comment '创建时间',
   ipaddr               varchar(50) not null default '' comment '发布ip地址',
   has_son              int(11) not null default 0 comment '跟帖条数',
   comments_type        int(11) not null default 0 comment '类型，备留字段',
   good                 int(11) not null default 0 comment '赞',
   bad                  int(11) not null default 0 comment '踩',
   reply                varchar(1000) not null default '' comment '评论管理员回复',
   primary key (comment_id)
)
engine=myisam default charset=utf8;

alter table comment_list comment '评论';

/*==============================================================*/
/* Table: company                                               */
/*==============================================================*/
create table company
(
   company_id           int(11) not null auto_increment comment '公司id',
   company_logo         varchar(100) not null default '' comment '公司logo',
   company_banner       varchar(100) not null default '' comment 'banner横幅',
   company_name         varchar(100) not null default '' comment '公司名称',
   seo_title            varchar(100) not null default '' comment '首页seo标题',
   seo_keywords         varchar(100) not null default '' comment '首页seo关键词',
   seo_description      varchar(200) not null default '' comment '首页seo描述',
   domain_type          int(11) not null default 0 comment '1=三级域名，2=独立域名',
   domain_py            varchar(100) not null default '' comment '三级域名拼音',
   domain               varchar(100) not null default '' comment '独立域名',
   style                varchar(20) not null default '' comment '独立网站模板风格',
   company_address      varchar(200) not null default '' comment '公司地址',
   company_tel          varchar(100) not null default '' comment '公司电话',
   company_fax          varchar(100) not null default '' comment '传真',
   company_about        varchar(1000) not null default '' comment '公司简介（公司网站首页）',
   qq                   varchar(100) not null default '' comment '公司QQ，逗号分开',
   contact              varchar(100) not null default '' comment '联系人',
   email                varchar(100) not null default '' comment '邮箱',
   foot_html            varchar(500) not null default '' comment '底部html',
   erweima              varchar(200) not null default '' comment '二维码,图片',
   weibo                varchar(200) not null default '' comment '新浪微博,url',
   company_type         int(11) unsigned not null default 0 comment '公司类型',
   company_hide_name    varchar(50) not null default '' comment '隐藏后的名称',
   not_true             int(11) unsigned not null default 0 comment '假账号（管理员添加的）',
   year                 int(11) unsigned not null default 0 comment '公司成立年份',
   scale                int(11) unsigned not null default 0 comment '公司规模',
   reg_assets           int(11) unsigned not null default 0 comment '注册资本',
   url                  varchar(200) not null default '' comment '网址',
   business_products    varchar(255) not null default '' comment '主营产品',
   business_stones      varchar(255) not null default '' comment '主营石种',
   primary key (company_id)
)
engine=myisam default charset=utf8;

alter table company comment '企业';

/*==============================================================*/
/* Table: company_ad                                            */
/*==============================================================*/
create table company_ad
(
   ad_id                int(11) unsigned not null auto_increment comment '广告ID',
   uid                  int(11) not null default 0 comment '用户ID',
   ad_name              varchar(100) not null default '' comment '广告名称',
   ad_img               varchar(255) not null default '' comment '图片',
   ad_url               text not null default '' comment '地址',
   ad_order             int(11) default 0 comment '排序',
   primary key (ad_id)
)
engine=myisam default charset=utf8;

alter table company_ad comment '企业会员-广告';

/*==============================================================*/
/* Table: company_flink                                         */
/*==============================================================*/
create table company_flink
(
   flink_id             int(11) unsigned not null auto_increment comment '友情ID',
   uid                  int(11) not null default 0 comment '用户ID',
   flink_name           varchar(100) not null default '' comment '友链名称',
   flink_img            varchar(255) not null default '' comment '图片',
   flink_url            text not null default '' comment '地址',
   flink_order          int(11) default 0 comment '排序',
   primary key (flink_id)
)
engine=myisam default charset=utf8;

alter table company_flink comment '企业会员-友情链接';

/*==============================================================*/
/* Table: company_user_list                                     */
/*==============================================================*/
create table company_user_list
(
   uid                  int(11) unsigned not null auto_increment comment 'uid',
   company_id           char(10) comment '企业id',
   group_id             int(11) not null default 0 comment '会员组ID',
   uname                varchar(100) not null default '' comment '用户名',
   uname_true           varchar(100) not null default '' comment '真实姓名',
   city_id              int(11) not null default 0 comment '城市id',
   upass                varchar(100) not null default '' comment '密码',
   uemail               varchar(100) not null default '' comment '邮箱',
   uemail_verify        int(1) not null default 0 comment '邮箱是否验证',
   uqq                  varchar(100) not null default '' comment 'QQ',
   uphone               varchar(100) not null default '' comment '手机',
   uphone_verify        int(1) not null default 0 comment '手机是否验证',
   ustate               int(11) not null default 0 comment '用户状态（正常=0，停用=1）',
   audit                int(11) not null default 0 comment '审核状态（未审核=0，审核=1）',
   style                varchar(20) not null default '' comment '模板风格',
   reg_date             int(11) not null default 0 comment '注册地址',
   reg_ip               varchar(100) not null default '' comment '注册IP地址',
   forget_pass_code     varchar(100) not null default '' comment '重置密码验证字符串',
   email_activation_code varchar(100) not null default '' comment '邮箱激活验证字符串',
   cell_activation_code varchar(100) not null default '' comment '手机激活验证字符串',
   lastvisit_code       varchar(100) not null default '' comment '登录密钥',
   expire_date          int(11) not null default 0 comment '会员到期时间',
   user_money           decimal(10,2) not null default 0.00 comment '用户现有资金',
   beizhu               varchar(100) not null default '' comment '管理员备注',
   url_py               varchar(100) not null default '' comment 'url拼音别名',
   primary key (uid)
)
engine=myisam default charset=utf8 auto_increment=10000;

alter table company_user_list comment '企业会员';

/*==============================================================*/
/* Table: company_user_points                                   */
/*==============================================================*/
create table company_user_points
(
   points_id            int(11) unsigned not null auto_increment comment 'points_id',
   uid                  int(11) not null default 0 comment '用户ID',
   points               int(11) comment 'points',
   create_date          int(11) not null default 0 comment '积分产生时间',
   points_reason        varchar(100) not null default '' comment '积分产生原因',
   primary key (points_id)
)
engine=myisam default charset=utf8;

alter table company_user_points comment '企业会员-积分';

/*==============================================================*/
/* Table: company_water                                         */
/*==============================================================*/
create table company_water
(
   company_id           int(11) unsigned not null default 0 comment '企业id',
   info_id              int(11) unsigned not null default 0 comment '水种id',
   create_time          int(11) unsigned not null default 0 comment '加入时间',
   price                decimal(10,2) unsigned not null default 0 comment '价格',
   primary key (company_id, info_id)
);

alter table company_water comment '企业经营水种';

/*==============================================================*/
/* Table: coupons                                               */
/*==============================================================*/
create table coupons
(
   coupons_id           int(11) not null auto_increment comment 'id',
   uid                  int(11) not null default 0 comment '用户ID',
   coupons_state        int(11) not null default 0 comment '优惠卷状态(0=未使用,1=已使用)',
   coupons_money        int(11) unsigned not null default 0 comment '优惠卷面值',
   sent_time            int(11) not null default 0 comment '赠送时间',
   expire_time          int(11) not null default 0 comment '到期时间',
   primary key (coupons_id)
)
engine=myisam default charset=utf8;

alter table coupons comment '优惠券';

/*==============================================================*/
/* Table: cservice                                              */
/*==============================================================*/
create table cservice
(
   csno                 int unsigned not null auto_increment comment '编号',
   csname               char(8) not null default '' comment '客服名',
   groupid              smallint(6) unsigned unsigned not null default '0' comment '用户组',
   cspwd                varchar(128) not null default '' comment '密码',
   cssalt               varchar(32) not null default '' comment 'salt',
   cscreated            int(10) unsigned not null default '0' comment '创建时间',
   csemail              varchar(50) not null default '' comment '邮箱',
   csmobile             varchar(50) not null default '' comment '手机',
   csstatus             tinyint(1) unsigned not null default 0 comment '状态',
   csname_true          varchar(40) not null default '' comment '真实姓名',
   primary key (csno)
);

alter table cservice comment '系统用户';

/*==============================================================*/
/* Table: cservice_aclog                                        */
/*==============================================================*/
create table cservice_aclog
(
   log_id               int unsigned not null auto_increment comment '日志标识',
   sno                  mediumint(8) unsigned unsigned not null default '0' comment '客服编号',
   accode               mediumint(8) unsigned unsigned not null default '0' comment '动作编号',
   log_time             int(10) unsigned not null default '0' comment '操作时间',
   log_ip               char(15) not null default '' comment '操作ip',
   log_details          text default '' comment '操作细节',
   primary key (log_id)
);

alter table cservice_aclog comment '系统用户行为日志';

/*==============================================================*/
/* Table: cservice_group                                        */
/*==============================================================*/
create table cservice_group
(
   groupid              int unsigned not null auto_increment comment '用户组ID',
   groupname            varchar(50) not null default '' comment '用户组名称',
   sno                  mediumint(8) unsigned unsigned not null default '0' comment '录入者',
   created              int(10) unsigned unsigned not null default '0' comment '添加日期',
   status               tinyint(1) unsigned not null default 0 comment '状态',
   primary key (groupid)
);

alter table cservice_group comment '系统用户组';

/*==============================================================*/
/* Table: cservice_group_role                                   */
/*==============================================================*/
create table cservice_group_role
(
   groupid              smallint(6) unsigned not null comment '用户组ID',
   role_id              char(32) not null default '' comment '角色ID',
   created              int(10) unsigned not null default 0 comment '创建时间',
   primary key (groupid, role_id)
);

alter table cservice_group_role comment '用户组 - 角色';

/*==============================================================*/
/* Table: cservice_role                                         */
/*==============================================================*/
create table cservice_role
(
   role_id              int unsigned not null auto_increment comment '角色标识',
   role_name            varchar(50) not null default '' comment '角色名称',
   role_status          tinyint(1) unsigned not null default 0 comment '状态',
   b_module             char(10) not null default '' comment '所属模块',
   primary key (role_id)
);

alter table cservice_role comment '系统角色';

/*==============================================================*/
/* Table: cservice_role_authority                               */
/*==============================================================*/
create table cservice_role_authority
(
   role_id              int unsigned not null auto_increment comment '角色ID',
   authority_id         char(32) not null default '' comment '权限标识',
   created              int(10) unsigned unsigned not null default '0' comment '创建时间',
   primary key (role_id, authority_id)
);

alter table cservice_role_authority comment '角色-权限';

/*==============================================================*/
/* Table: cservice_roles                                        */
/*==============================================================*/
create table cservice_roles
(
   sno                  mediumint(8) unsigned not null comment '客服ID',
   role_id              char(32) not null comment '角色ID',
   created              int(10) unsigned not null comment '创建时间',
   primary key (sno, role_id)
);

alter table cservice_roles comment '系统用户 - 角色';

/*==============================================================*/
/* Table: exchange_code                                         */
/*==============================================================*/
create table exchange_code
(
   exchange_code_id     int(11) not null auto_increment comment '兑换码id',
   exchange_code        varchar(50) not null default '' comment '兑换码',
   uid                  int(11) not null default 0 comment '用户ID',
   exchange_state       int(11) not null default 0 comment '兑换状态(0=未兑换,1=已兑换)',
   exchange_time        int(11) not null default 0 comment '兑换时间',
   primary key (exchange_code_id)
)
engine=myisam default charset=utf8;

alter table exchange_code comment '兑换码';

/*==============================================================*/
/* Table: exchange_goods                                        */
/*==============================================================*/
create table exchange_goods
(
   id                   int(11) not null auto_increment comment '自增id',
   goods_id             int(11) not null default 0 comment '商品id',
   goods_order          int(11) not null default 0 comment '排序',
   exchange_point       int(11) not null default 0 comment '兑换积分',
   is_exchange          int(11) not null default 0 comment '是否可兑换',
   is_hot               int(11) not null default 0 comment '是否热销',
   primary key (id)
)
engine=myisam default charset=utf8;

alter table exchange_goods comment '兑换商品';

/*==============================================================*/
/* Table: flink                                                 */
/*==============================================================*/
create table flink
(
   flink_id             int(11) unsigned not null auto_increment comment '友情ID',
   flink_hosturl        varchar(255) not null default '' comment '域名地址或分类地址',
   flink_name           varchar(100) not null default '' comment '友链名称',
   flink_img            varchar(255) not null default '' comment '图片',
   flink_url            text not null default '' comment '地址',
   flink_is_site        int(11) default 0 comment '0=首页，1代表全站',
   city_id              int(11) not null default 0 comment '城市或区域ID',
   flink_order          int(11) default 0 comment '排序',
   primary key (flink_id)
)
engine=myisam default charset=utf8;

alter table flink comment '友情链接';

/*==============================================================*/
/* Table: group_goods                                           */
/*==============================================================*/
create table group_goods
(
   id                   int(11) not null auto_increment comment '自增id',
   group_goods_name     varchar(255) not null default '' comment '团购名称',
   goods_id             int(11) not null default 0 comment '商品id',
   goods_order          int(11) not null default 0 comment '排序',
   group_price          decimal(11,2) unsigned not null default 0 comment '团购价',
   start_time           int(11) not null default 0 comment '开始时间',
   end_time             int(11) not null default 0 comment '结束时间',
   restrict_amount      int(11) not null default 0 comment '达到此数量，团购活动自动结束。0表示没有数量限制。',
   act_desc             text not null default '' comment '活动介绍',
   ladder               text not null default '' comment '价格阶梯,json 格式  [{"amount":10,"price":330},{"amount":20,"price":300}]',
   primary key (id)
)
engine=myisam default charset=utf8;

alter table group_goods comment '团购-商品';

/*==============================================================*/
/* Table: info_category                                         */
/*==============================================================*/
create table info_category
(
   cate_id              int(11) unsigned not null auto_increment comment '类别id',
   model_id             int(11) not null default 0 comment '模型ID',
   parent_id            int(11) not null default 0 comment '父类id',
   relation_cate_id     int(11) not null default 0 comment '关联分类',
   cname                varchar(100) not null default '' comment '分类名称',
   cname_py             varchar(100) not null default '' comment '分类字母别名',
   cname_en             varchar(50) not null default '' comment '英文名',
   cimg                 varchar(500) not null default '' comment '分类LOGO图片URL地址',
   ctitle               varchar(500) not null default '' comment 'SEO标题',
   ckey                 varchar(500) not null default '' comment 'SEO关键词',
   cdesc                varchar(500) not null default '' comment 'SEO描述',
   cbody                text not null default '' comment '分类介绍',
   corder               int(11) not null default 0 comment '分类排序',
   cvistors             int(11) not null default 0 comment '分类浏览量',
   totals               int(11) unsigned not null default 0 comment '数据量',
   cjump_url            varchar(255) not null default '' comment '手动填写url',
   jump_first_cate      int(11) not null default 0 comment '是否跳转到第一个子分类',
   csetting             text not null default '' comment '设置，模版等 json格式',
   field_setting        text not null default '' comment '设置 需要隐藏的字段 json格式 ',
   getcateids           varchar(255) not null default '' comment '同时获取指定栏目内容（用英文逗号隔开）',
   cate_host            varchar(100) not null default '' comment '绑定域名',
   host_is_top          int(11) not null default 0 comment '域名作为 该分类的url，1为是，0为否 ',
   ad_area_id           int(11) not null default 0 comment '绑定广告位ID',
   pagesize             int(11) not null default 0 comment '每页显示大小',
   nav_show             int(11) not null default 0 comment '导航显示',
   highlight            int(11) not null default 0 comment '高亮(否=0，是=1)',
   recommend            int(11) not null default 0 comment '推荐(否=0，是=1)',
   single               int(11) not null default 0 comment '单篇介绍(否=0，是=1)',
   extern_content       text not null default '' comment '扩展数据，类似模型，但是都保存在本字段的json',
   primary key (cate_id)
)
engine=myisam default charset=utf8;

alter table info_category comment '信息分类';

/*==============================================================*/
/* Table: info_info_relation                                    */
/*==============================================================*/
create table info_info_relation
(
   relation_id          int(11) unsigned not null auto_increment comment '关系ID',
   info_id              int(11) not null default 0 comment '资讯ID',
   model_id             int(11) not null default 0 comment '模型ID',
   info_id_related      int(11) not null default 0 comment '关联资讯ID',
   model_id_related     int(11) not null default 0 comment '关联资讯ID的模型ID',
   displayorder         int(11) not null default 0 comment '显示顺序',
   type                 int(11) unsigned not null default 0 comment '类型(特殊)',
   primary key (relation_id)
)
engine=myisam default charset=utf8;

alter table info_info_relation comment '信息相关推荐';

/*==============================================================*/
/* Table: info_special                                          */
/*==============================================================*/
create table info_special
(
   special_id           int(11) not null auto_increment comment '专题id',
   cate_id_top          int(11) not null default 0 comment '顶级类别id',
   special_parent_id    int(11) not null default 0 comment '专题上级分类',
   special_name         varchar(100) not null default '' comment '专题名称',
   special_desc         varchar(8000) not null default '' comment '专题介绍',
   special_img          varchar(500) not null default '' comment '专题缩略图',
   special_banner       varchar(500) not null default '' comment '专题横幅',
   template             varchar(100) not null default '' comment '专题模版',
   sorder               int(11) not null default 0 comment '排序',
   typesetting          text not null default '' comment '本专题的小分类json格式,   如 1=>最新报道 2=>视频报道等自定义 ',
   info_id              int(11) not null default 0 comment '资讯的ID',
   special_editor       varchar(50) not null default '' comment '会员名称',
   uid                  int(11) not null default 0 comment '会员id',
   audit                int(11) not null default 0 comment '审核状态（0=未审核，1=已审核）',
   create_date          int(11) not null default 0 comment '创建日期',
   primary key (special_id)
)
engine=myisam default charset=utf8;

alter table info_special comment '专题';

/*==============================================================*/
/* Table: info_special_relation                                 */
/*==============================================================*/
create table info_special_relation
(
   relation_id          int(11) unsigned not null auto_increment comment '关系ID',
   special_id           int(11) not null default 0 comment '专题ID',
   info_id              int(11) not null default 0 comment '资讯ID',
   model_id             int(11) not null default 0 comment '模型ID',
   special_type         varchar(100) not null default '' comment '所属某专题的小分类（从typesetting里选择）',
   info_title           varchar(255) not null default '' comment '缓存标题',
   i_s_order            int(11) not null default 0 comment '排序',
   primary key (relation_id)
)
engine=myisam default charset=utf8;

alter table info_special_relation comment '专题-信息关联';

/*==============================================================*/
/* Table: linkage                                               */
/*==============================================================*/
create table linkage
(
   linkage_id           int(11) unsigned not null auto_increment comment 'linkage_id',
   linkage_type_id      int(11) not null default 0 comment '类型ID',
   parent_id            int(11) not null default 0 comment '父ID',
   linkage_name         varchar(100) not null default '' comment '名称',
   linkage_name_py      varchar(100) not null default '' comment '别名',
   linkage_deep         int(11) not null default 0 comment '层级别',
   linkage_remark       int(11) not null default 0 comment '自定义标识',
   linkage_attr         int(11) not null default 0 comment '自定义属性，热门等',
   linkage_order        int(11) not null default 0 comment '排序',
   icon                 varchar(255) not null default '' comment '图标',
   primary key (linkage_id)
)
engine=myisam default charset=utf8;

alter table linkage comment '联动菜单';

/*==============================================================*/
/* Table: linkage_type                                          */
/*==============================================================*/
create table linkage_type
(
   linkage_type_id      int(11) unsigned not null auto_increment comment 'linkage_type_id',
   linkage_type_name    varchar(100) not null default '' comment '名称',
   linkage_type_order   int(11) not null default 0 comment '排序',
   primary key (linkage_type_id)
)
engine=myisam default charset=utf8;

alter table linkage_type comment '联动菜单-分类';

/*==============================================================*/
/* Table: model                                                 */
/*==============================================================*/
create table model
(
   model_id             int(11) not null auto_increment comment '模型ID',
   model_type           int(11) not null default 0 comment '0=内容模型，1=表单模型（独立表）',
   parent_model_id      int(11) not null default 0 comment '父模型id',
   model_name           varchar(50) not null default '' comment '模型名称',
   model_table_name     varchar(50) not null default '' comment '模型的表名称',
   cmodel_id            varchar(100) not null default '0' comment '模型子表的ID',
   is_system            int(11) not null default 0 comment '是否是系统',
   primary key (model_id)
)
engine=myisam default charset=utf8;

alter table model comment '内容模型';

/*==============================================================*/
/* Table: model_field                                           */
/*==============================================================*/
create table model_field
(
   field_id             int(11) not null auto_increment comment '字段ID',
   model_id             int(11) not null default 0 comment '模型ID',
   field_name           varchar(100) not null default '' comment '字段',
   field_txt            varchar(50) not null default '' comment '提示文字',
   form_type            varchar(50) not null default '' comment '表单类型',
   setting              text not null default '' comment 'json格式，默认值，选中值等',
   tips                 varchar(255) not null default '' comment '表单提示附加',
   pattern              varchar(100) not null default '' comment '数据检验正则',
   length               varchar(50) not null default '' comment '文本长度',
   linkage_type_id      int(11) not null default 0 comment '联动类型ID',
   linkage_select_parent_id int(11) not null default 0 comment '联动类型从哪个分类开始',
   linkage_select_selectnum int(11) not null default 0 comment '联动类型的select限制数量',
   field_order          int(11) not null default 0 comment '排序',
   is_system            int(11) not null default 0 comment '是否为系统字段',
   list_show            int(11) not null default 0 comment '是否在后台列表中 显示0=显示，1不显示',
   primary key (field_id)
)
engine=myisam default charset=utf8;

alter table model_field comment '内容模型字段';

/*==============================================================*/
/* Table: nlink                                                 */
/*==============================================================*/
create table nlink
(
   nlink_id             int(11) unsigned not null auto_increment comment '内链ID',
   nlink_txt            varchar(50) not null default '' comment '名称',
   nlink_url            text not null default '' comment '网址',
   norder               int(11) not null default 0 comment '排序',
   primary key (nlink_id)
)
engine=myisam default charset=utf8;

alter table nlink comment '内链关键词';

/*==============================================================*/
/* Table: order_goods                                           */
/*==============================================================*/
create table order_goods
(
   order_goods_id       mediumint(8) unsigned not null auto_increment comment '订单商品信息自增id',
   order_id             mediumint(8) unsigned not null default 0 comment '订单商品信息对应的详细信息id，取值order_info的order_id',
   goods_id             mediumint(8) unsigned not null default 0 comment '商品的的id，取值表ecs_goods 的goods_id',
   goods_name           varchar(120) not null comment '商品的名称，取值表ecs_goods ',
   goods_img            varchar(120) not null comment '商品的缩略图',
   goods_sn             varchar(60) not null comment '商品的唯一货号，取值ecs_goods ',
   goods_number         smallint(5) unsigned not null default 1 comment '商品的购买数量',
   market_price         decimal(10,2) not null default 0.00 comment '商品的市场售价，取值ecs_goods ',
   goods_price          decimal(10,2) not null default 0.00 comment '商品的本店售价，取值ecs_goods ',
   goods_attr           text not null comment '购买该商品时所选择的属性；',
   send_number          smallint(5) unsigned not null default 0 comment '当不是实物时，是否已发货，0，否；1，是',
   is_real              tinyint(1) unsigned not null default 0 comment '是否是实物，0，否；1，是；取值ecs_goods ',
   extension_code       varchar(30) not null comment '商品的扩展属性，比如像虚拟卡。取值ecs_goods ',
   parent_id            mediumint(8) unsigned not null default 0 comment '父商品id，取值于ecs_cart的parent_id；如果有该值则是值多代表的物品的配件',
   is_gift              smallint(5) unsigned not null default 0 comment '是否参加优惠活动，0，否；其他，取值于ecs_cart 的is_gift，跟其一样，是参加的优惠活动的id',
   gift_detail          varchar(120) not null default '' comment '优惠说明',
   primary key (order_goods_id)
)
ENGINE=myisam default CHARSET=utf8  comment='订单的商品信息' auto_increment=1;

alter table order_goods comment '订单商品';

/*==============================================================*/
/* Table: pm_list                                               */
/*==============================================================*/
create table pm_list
(
   pm_id                int(11) unsigned not null auto_increment comment 'pm_id',
   pm_title             varchar(100) not null default '' comment '标题',
   pm_body              text not null default '' comment '内容',
   uid_post             int(11) not null default 0 comment '发出站内信用户ID',
   uid_recv             int(11) comment 'uid_recv',
   post_date            int(11) not null default 0 comment '发送时间',
   recv_date            int(11) not null default 0 comment '接收（阅读）时间，可用户判断接收用户是否已读',
   pm_type              int(1) not null default 0 comment '站内信类型（系统=1，用户=2）',
   primary key (pm_id)
)
engine=myisam default charset=utf8;

alter table pm_list comment '站内信';

/*==============================================================*/
/* Table: pm_read                                               */
/*==============================================================*/
create table pm_read
(
   read_id              int(11) unsigned not null auto_increment comment 'read_id',
   pm_id                int(11) not null default 0 comment '阅读用户ID',
   uid                  int(11) not null default 0 comment 'uid',
   read_date            int(11) not null default 0 comment '阅读时间，判断用户是否已读',
   primary key (read_id)
)
engine=myisam default charset=utf8;

alter table pm_read comment '站内信-标记';

/*==============================================================*/
/* Table: recommend                                             */
/*==============================================================*/
create table recommend
(
   recommend_id         int(11) unsigned not null auto_increment comment '关系ID',
   recommend_name       varchar(100) not null default '' comment '推荐位名称',
   table_name           varchar(100) not null default '' comment '数据表名',
   id_field             varchar(100) not null default '' comment '数据表的ID字段名',
   name_field           varchar(100) not null default '' comment '数据表的name字段名',
   inid                 varchar(1000) not null default '' comment '文档ID的集合，以逗号隔开',
   recommend_order      int(11) not null default 0 comment '推荐位排序',
   primary key (recommend_id)
)
engine=myisam default charset=utf8;

alter table recommend comment '推荐位';

/*==============================================================*/
/* Table: recv_address                                          */
/*==============================================================*/
create table recv_address
(
   recv_address_id      int(11) not null auto_increment comment '地址id',
   uid                  int(11) not null default 0 comment '用户id',
   recv_address         varchar(255) not null default '' comment '收货地址',
   recv_contact         varchar(20) not null default '' comment '联系人',
   recv_cellphone       varchar(20) not null default '' comment '手机号',
   recv_tel             varchar(50) not null default '' comment '电话号码',
   recv_email           varchar(20) not null default '' comment '邮箱',
   citydata             varchar(200) not null default '' comment '城市区域，json格式',
   zip_code             varchar(20) not null default '' comment '邮政编码',
   is_default           int(11) not null default 0 comment '是否为默认收货地址',
   create_time          int(11) not null default 0 comment '创建时间',
   primary key (recv_address_id)
)
engine=myisam default charset=utf8;

alter table recv_address comment '收货地址';

/*==============================================================*/
/* Table: resource_list                                         */
/*==============================================================*/
create table resource_list
(
   resource_id          int(11) unsigned not null auto_increment comment '关系ID',
   fromid               varchar(50) not null default '0' comment '标识',
   resource_url         varchar(255) not null default '' comment '资源地址',
   resource_type        int(11) not null default 0 comment '资源类型（图片=1，FLASH=2，视频=3，下载=4）',
   r_width              int(11) not null default 0 comment '资源宽度',
   r_height             int(11) not null default 0 comment '资源高度',
   r_size               int(11) not null default 0 comment '资源大小',
   resource_order       int(11) not null default 0 comment '排序',
   r_name               varchar(100) not null default '' comment '资源名称',
   mark                 int(11) unsigned not null default 0 comment '属性标记',
   primary key (resource_id)
)
engine=myisam default charset=utf8;

alter table resource_list comment '资源附件';

/*==============================================================*/
/* Table: rewrite                                               */
/*==============================================================*/
create table rewrite
(
   rewrite_id           int(11) unsigned not null auto_increment comment '伪静态id',
   rewrite_ident        varchar(50) not null default '' comment '调用标识',
   rewrite_name         varchar(100) not null default '' comment '伪静态名称',
   rewrite_type         int(11) not null default 0 comment '类型(0=列表,1=详情页,2=其他)',
   rewrite_example      varchar(255) not null default '' comment '示例',
   true_url             varchar(255) not null default '' comment 'url原型',
   rewrite_rule         varchar(255) not null default '' comment '伪静态规则',
   rewrite_page_rule    varchar(255) not null default '' comment '伪静态规则（页码）',
   rewrite_order        int(11) not null default 0 comment '排序',
   primary key (rewrite_id)
)
engine=myisam default charset=utf8;

alter table rewrite comment '伪静态';

/*==============================================================*/
/* Table: shipping                                              */
/*==============================================================*/
create table shipping
(
   shipping_id          tinyint(3) unsigned not null auto_increment comment '自增ID号',
   shipping_code        varchar(20) not null comment '配送方式的字符串代号',
   shipping_name        varchar(120) not null comment '配送方式的名称',
   shipping_desc        varchar(255) not null comment '配送方式的描述',
   insure               varchar(10) not null default '0' comment '保价费用，单位元，或者是百分数，该值直接输出为报价费用',
   enabled              tinyint(1) unsigned not null default 0 comment '该配送方式是否被禁用，1，可用；0，禁用',
   primary key (shipping_id)
)
ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC comment='配送方式配置信息表' auto_increment=9;

alter table shipping comment '配送方式';

/*==============================================================*/
/* Table: site_seo                                              */
/*==============================================================*/
create table site_seo
(
   id                   int(11) unsigned not null auto_increment comment 'id',
   mark                 varchar(200) not null default '' comment '备注',
   url                  varchar(400) not null comment '页面地址',
   seo_title            varchar(400) not null default '' comment 'seo标题',
   seo_keyword          varchar(400) not null default '' comment 'seo关键词',
   seo_description      varchar(800) not null default '' comment 'seo描述',
   create_time          int(11) unsigned not null default 0 comment '创建时间',
   displayorder         int(11) unsigned not null default 0 comment '显示顺序',
   primary key (id)
);

alter table site_seo comment 'seo页面设置';

/*==============================================================*/
/* Table: tag                                                   */
/*==============================================================*/
create table tag
(
   tag_id               int(11) unsigned not null auto_increment comment 'ID',
   tag_cate_id          int(11) not null default 0 comment '标签分类',
   tag_txt              varchar(50) not null default '' comment '文字',
   tag_order            int(11) not null default 0 comment '排序',
   primary key (tag_id)
)
engine=myisam default charset=utf8;

alter table tag comment '标签';

/*==============================================================*/
/* Table: tag_cate                                              */
/*==============================================================*/
create table tag_cate
(
   tag_cate_id          int(11) unsigned not null auto_increment comment 'ID',
   tag_cate_name        varchar(50) not null default '' comment '名称',
   info_cate_id         int(11) not null default 0 comment '资讯分类id',
   tag_cate_order       int(11) not null default 0 comment '排序',
   primary key (tag_cate_id)
)
engine=myisam default charset=utf8;

alter table tag_cate comment '标签-分类';

/*==============================================================*/
/* Table: tbk_goods_link                                        */
/*==============================================================*/
create table tbk_goods_link
(
   num_iid              bigint(32) unsigned not null auto_increment comment '淘宝商品id',
   link_url             text not null default '' comment '链接地址',
   status               int(11) unsigned not null default 0 comment '状态(0=待检测,2=无效,1=有效)',
   isdel                int(11) unsigned not null default 0 comment '本站是否被删除(0=未删除,1=已删除)',
   clicknums            int(11) unsigned not null default 0 comment '点击次数',
   goods_title          varchar(255) not null default '' comment '商品标题',
   goods_cover          varchar(255) not null default '' comment '商品封面',
   goods_id             int(11) unsigned not null default 0 comment '商品ID',
   last_check_time      int(11) unsigned not null default 0 comment '上次检测日期',
   primary key (num_iid)
);

alter table tbk_goods_link comment '商品状态统计';

/*==============================================================*/
/* Table: templates_desc                                        */
/*==============================================================*/
create table templates_desc
(
   id                   int(11) not null auto_increment comment 'id',
   file_name            varchar(50) not null default '' comment '文件名',
   "desc"               varchar(50) not null default '' comment '模版类型说明',
   primary key (id)
)
engine myisam default charset=utf8;

alter table templates_desc comment '模板说明';

/*==============================================================*/
/* Table: user_collect                                          */
/*==============================================================*/
create table user_collect
(
   collect_id           mediumint(8) not null auto_increment comment '收藏记录的自增id',
   uid                  mediumint(8) not null default 0 comment '该条收藏记录的会员id，取值于ecs_users的user_id',
   info_id              mediumint(8) not null default 0 comment '收藏的id',
   table_name           varchar(8) not null default '0' comment '信息的数据表，表名',
   add_time             int(11) not null default 0 comment '收藏时间',
   primary key (collect_id)
)
engine=myisam default charset=utf8;

alter table user_collect comment '会员-收藏';

/*==============================================================*/
/* Table: user_extern                                           */
/*==============================================================*/
create table user_extern
(
   uid                  int(11) not null default 0 comment '用户ID',
   sex                  int(2) not null default 0 comment '性别（女=1，男=2）',
   tou_img              varchar(100) not null default '' comment '头像地址',
   birth_day            int(11) not null default 0 comment '出生年月日',
   constellation        varchar(20) not null default '' comment '星座',
   signature            varchar(100) not null default '' comment '个性签名',
   occupation           varchar(20) not null default '' comment '职业',
   primary key (uid)
)
engine=myisam default charset=utf8;

alter table user_extern comment '会员扩展资料';

/*==============================================================*/
/* Table: user_fans                                             */
/*==============================================================*/
create table user_fans
(
   id                   int(11) unsigned not null auto_increment comment 'id',
   uid                  int(11) unsigned not null default 0 comment '关注人（主动）',
   uid2                 int(11) unsigned not null default 0 comment '被关注人',
   create_time          int(11) unsigned not null default 0 comment '关注时间',
   primary key (id)
);

alter table user_fans comment '用户-粉丝/关注';

/*==============================================================*/
/* Table: user_group                                            */
/*==============================================================*/
create table user_group
(
   group_id             int(11) not null auto_increment comment '组ID',
   group_name           varchar(50) not null default '' comment '组名称',
   is_system            text not null default '' comment '是否是系统',
   group_level          text not null default '' comment 'json格式,组权限',
   group_rank           int(11) not null default 0 comment '权限值',
   primary key (group_id)
)
engine=myisam default charset=utf8;

alter table user_group comment '会员组';

/*==============================================================*/
/* Table: user_list                                             */
/*==============================================================*/
create table user_list
(
   uid                  int(11) unsigned not null auto_increment comment 'uid',
   group_id             int(11) not null default 0 comment '会员组ID',
   uname                varchar(100) not null default '' comment '用户名',
   uname_true           varchar(100) not null default '' comment '真实姓名',
   upass                varchar(100) not null default '' comment '密码',
   uemail               varchar(100) not null default '' comment '邮箱',
   uemail_verify        int(1) not null default 0 comment '邮箱是否验证',
   uqq                  varchar(100) not null default '' comment 'QQ',
   uphone               varchar(100) not null default '' comment '手机',
   uphone_verify        int(1) not null default 0 comment '手机是否验证',
   ustate               int(11) not null default 0 comment '用户状态（正常=0，停用=1）',
   reg_date             int(11) not null default 0 comment '注册地址',
   reg_ip               varchar(100) not null default '' comment '注册IP地址',
   forget_pass_code     varchar(100) not null default '' comment '重置密码验证字符串',
   email_activation_code varchar(100) not null default '' comment '邮箱激活验证字符串',
   cell_activation_code varchar(100) not null default '' comment '手机激活验证字符串',
   lastvisit_code       varchar(100) not null default '' comment '登录密钥',
   expire_date          int(11) not null default 0 comment '会员到期时间',
   user_money           decimal(10,2) not null default 0.00 comment '用户现有资金',
   user_vitual_money    decimal(10,1) not null default 0.00 comment '用户现有虚拟币',
   fans_total           int(11) unsigned not null default 0 comment '粉丝数量',
   primary key (uid)
)
auto_increment = 10000;

alter table user_list comment '会员';

/*==============================================================*/
/* Table: user_login                                            */
/*==============================================================*/
create table user_login
(
   logs_id              int(11) unsigned not null auto_increment comment 'logs_id',
   uid                  int(11) not null default 0 comment '用户ID',
   login_date           int(11) not null default 0 comment '登录时间',
   login_ip             varchar(100) not null default '' comment '登录地址',
   primary key (logs_id)
)
engine=myisam default charset=utf8;

alter table user_login comment '会员登录记录';

/*==============================================================*/
/* Table: user_order                                            */
/*==============================================================*/
create table user_order
(
   user_order_id        int(11) not null auto_increment comment '订单id',
   trade_no             varchar(50) not null default '' comment '本站订单号 唯一',
   pay_trade_no         varchar(50) not null default '' comment '服务商的订单号',
   uid                  int(11) not null default 0 comment '用户id',
   sessionid            varchar(50) not null default '' comment '游客会话id',
   pay_type             int(11) not null default 0 comment '支付方式（支付宝=1，财付通=2,网银在线=3...）',
   order_state          int(11) not null default 0 comment '订单状态(0=等待付款,1=已经付款，等待发货,2=已发货，等待确认收货,3=交易成功)',
   invoice_number       varchar(100) not null default '' comment '发货单号',
   consignee            varchar(60) not null comment '收货人的姓名，用户页面填写，默认取值于表user_address',
   send_goods           int(11) not null default 0 comment '发货状态（0=未发货,1=已发货）',
   address              varchar(255) not null comment '收货人的详细地址，用户页面填写，默认取值于表user_address',
   mobile               varchar(60) not null comment '收货人的手机，用户页面填写，默认取值于表user_address',
   tel                  varchar(50) not null default '' comment '电话号码',
   email                varchar(60) not null comment 'email',
   postscript           varchar(255) not null comment '订单附言，由用户提交订单前填写',
   tohours              varchar(50) not null default '' comment '送到时间段（用户选择）',
   shipping_id          tinyint(3) not null default 0 comment '用户选择的配送方式id，取值表ecs_shipping',
   shipping_name        varchar(120) not null comment '用户选择的配送方式的名称，取值表ecs_shipping',
   shipping_fee         int(11) not null default 0 comment '配送费用',
   is_gift              smallint(5) unsigned not null default 0 comment '是否参加了优惠活动0=否，1=是',
   gift_detail          varchar(120) not null default '' comment '优惠说明',
   order_cate           int(11) not null default 0 comment '订单分类,1=快点,2=金和楼,3=综合',
   order_money_count    decimal(11,2) not null default 0 comment '总计',
   create_time          int(11) not null default 0 comment '订单创建时间',
   extension_code       varchar(30) not null comment '通过活动购买的商品的代号；exchange_goods是积分商城，group_by是团购；auction，是拍卖；正常普通产品该处为空',
   extension_id         int(11) unsigned not null default 0 comment '通过活动购买的物品的id',
   pay_time_complete    int(11) not null default 0 comment '完成付款时间',
   integral             int(11) unsigned not null default 0 comment '使用的积分数量',
   primary key (user_order_id)
)
engine=myisam default charset=utf8;

alter table user_order comment '订单';

/*==============================================================*/
/* Table: user_pay                                              */
/*==============================================================*/
create table user_pay
(
   pay_id               int(11) not null auto_increment comment '自增id',
   trade_no             varchar(50) not null default '' comment '本站订单号 唯一',
   order_id             int(11) not null default 0 comment '商品订单id',
   coupons_id           int(11) not null default 0 comment '优惠券id',
   user_money           decimal(11,2) not null default 0 comment '会员余额',
   pay_trade_no         varchar(50) not null default '' comment '服务商的订单号',
   uid                  int(11) not null default 0 comment '用户id',
   sessionid            varchar(50) not null default '' comment '游客会话id',
   money                decimal(11,2) not null default 0 comment '充值金额',
   pay_time             int(11) not null default 0 comment '支付创建时间',
   pay_time_complete    int(11) not null default 0 comment '支付成功时间',
   pay_state            int(11) not null default 0 comment '支付状态（成功=1，失败=0）',
   pay_type             int(11) not null default 0 comment '支付方式（支付宝=1，财付通=2,网银在线=3...）',
   ip                   varchar(50) not null default '' comment 'IP地址',
   primary key (pay_id)
)
engine=myisam default charset=utf8;

alter table user_pay comment '会员-充值';

/*==============================================================*/
/* Table: user_points                                           */
/*==============================================================*/
create table user_points
(
   points_id            int(11) unsigned not null auto_increment comment 'points_id',
   uid                  int(11) not null default 0 comment '用户ID',
   points               int(11) comment 'points',
   create_date          int(11) not null default 0 comment '积分产生时间',
   points_reason        varchar(100) not null default '' comment '积分产生原因',
   primary key (points_id)
)
engine=myisam default charset=utf8;

alter table user_points comment '会员-积分';

/*==============================================================*/
/* Table: user_star                                             */
/*==============================================================*/
create table user_star
(
   id                   int(11) unsigned not null auto_increment comment 'id',
   uid                  int(11) unsigned not null default 0 comment '用户id',
   cover                varchar(255) not null default '' comment '图片',
   create_time          int(11) unsigned not null default 0 comment '推荐时间',
   reason               varchar(100) not null default '' comment '推荐理由',
   primary key (id)
);

alter table user_star comment '用户-达人';

/*==============================================================*/
/* Table: user_thirdpassport                                    */
/*==============================================================*/
create table user_thirdpassport
(
   id                   int(10) unsigned not null auto_increment comment '编号',
   uid                  int(10)  unsigned not null comment '用户ID',
   media_type           tinyint(1) unsigned unsigned not null comment '类型',
   openid               char(50) not null comment 'openid',
   user_data            text comment '第三方账号资料',
   created              int(10)  unsigned not null comment '创建时间',
   primary key (id)
);

alter table user_thirdpassport comment '用户-第三方登录';

/*==============================================================*/
/* Table: user_visit_history                                    */
/*==============================================================*/
create table user_visit_history
(
   id                   int(11) unsigned not null auto_increment comment 'id',
   uid                  int(11) unsigned not null default 0 comment '用户ID',
   model_id             int(11) unsigned not null default 0 comment '信息类型',
   info_id              int(11) unsigned not null default 0 comment '信息id',
   create_time          int(11) unsigned not null default 0 comment '浏览时间',
   primary key (id)
);

alter table user_visit_history comment '会员-浏览记录';

/*==============================================================*/
/* Table: vote_data                                             */
/*==============================================================*/
create table vote_data
(
   data_id              int(11) unsigned not null auto_increment comment '自增ID',
   uid                  int(8) unsigned not null comment '用户ID',
   uname                varchar(50) not null default '' comment '用户名',
   subject_id           int(11) not null default 0 comment '选项ID',
   time                 int(11) not null default 0 comment '投票时间',
   ip                   varchar(50) not null default '' comment 'ip',
   data                 varchar(255) not null default '' comment '投票的数据,json格式 [3,5,6]，表示 投给了 3，5，6',
   primary key (data_id)
)
engine=myisam default charset=utf8;

alter table vote_data comment '投票-数据';

/*==============================================================*/
/* Table: vote_option                                           */
/*==============================================================*/
create table vote_option
(
   option_id            int(8) unsigned not null auto_increment comment '选项ID',
   subject_id           int(8) unsigned not null default 0 comment 'subject_id',
   "option"             varchar(255) not null default '' comment '选项名称',
   option_order         tinyint(2) unsigned default 0 comment '排序',
   primary key (option_id)
)
engine=myisam default charset=utf8;

alter table vote_option comment '投票选项';

/*==============================================================*/
/* Table: vote_subject                                          */
/*==============================================================*/
create table vote_subject
(
   subject_id           int(11) unsigned not null auto_increment comment '主题id',
   subject              varchar(255) not null default '' comment '标题',
   subject_desc         varchar(255) not null default '' comment '介绍',
   is_checkbox          int(11) not null default 0 comment '是否复选',
   minval               int(11) not null default 0 comment '最少选项',
   maxval               int(11) not null default 0 comment '最大选项',
   start_time           int(11) not null default 0 comment '上线时间',
   end_time             int(11) not null default 0 comment '下线时间',
   allowview            int(11) not null default 0 comment '是否允许查看投票结果',
   allowguest           int(11) not null default 0 comment '是否允许游客投票',
   reward_point         int(11) not null default 0 comment '奖励积分',
   optionnumeber        int(11) not null default 0 comment '选项数量',
   votenumeber          int(11) not null default 0 comment '共计投票',
   enabled              int(11) not null default 0 comment '是否启用,0=未启用,1=启用',
   create_time          int(11) not null default 0 comment '创建时间',
   template             varchar(100) not null default '' comment '模版',
   subject_order        int(11) not null default 0 comment '排序',
   limit_day            int(11) not null default 0 comment '间隔时间允许投票，天为单位，',
   primary key (subject_id)
)
engine=myisam default charset=utf8;

alter table vote_subject comment '投票主题';

/*==============================================================*/
/* Table: wechat_user                                           */
/*==============================================================*/
create table wechat_user
(
   uid                  int(11) unsigned not null default 0 comment '用户id',
   openid               int(11) unsigned not null default 0 comment '微信id',
   create_time          int(11) unsigned not null default 0 comment '绑定时间',
   primary key (uid, openid)
);

alter table wechat_user comment '微信账号';
