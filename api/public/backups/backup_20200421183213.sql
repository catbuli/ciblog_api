-- MariaDB dump 10.17  Distrib 10.4.10-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: ciblog
-- ------------------------------------------------------
-- Server version	10.4.10-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ciblog_article`
--

DROP TABLE IF EXISTS `ciblog_article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ciblog_article` (
  `aid` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章编号',
  `title` longtext DEFAULT NULL COMMENT '文章标题',
  `html` longtext DEFAULT NULL COMMENT '文章h5',
  `text` longtext DEFAULT NULL COMMENT '文章正文',
  `create_date` datetime DEFAULT NULL COMMENT '发表时间',
  `modify_date` datetime DEFAULT NULL COMMENT '最后编辑时间',
  `order` int(255) DEFAULT NULL COMMENT '排序',
  `author_id` int(11) DEFAULT NULL COMMENT '作者id',
  `status` varchar(255) DEFAULT '0' COMMENT '0-发布 无草稿\r\n1-发布 有草稿\r\n2-未发布 有草稿',
  `comment_count` int(11) unsigned DEFAULT 0 COMMENT '评论数',
  `allow_comment` int(11) unsigned DEFAULT 1 COMMENT '0-不允许\r\n1-允许',
  `pv` int(255) DEFAULT 0 COMMENT '阅读量',
  `cover_url` longtext DEFAULT NULL COMMENT '封面连接',
  `description` longtext CHARACTER SET utf32 DEFAULT NULL COMMENT '描述',
  `draft` longtext DEFAULT NULL COMMENT '草稿',
  PRIMARY KEY (`aid`) USING BTREE,
  FULLTEXT KEY `search` (`title`,`text`),
  FULLTEXT KEY `search1` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=161 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ciblog_article`
--

LOCK TABLES `ciblog_article` WRITE;
/*!40000 ALTER TABLE `ciblog_article` DISABLE KEYS */;
INSERT INTO `ciblog_article` VALUES (133,'cccc','<p>cccc</p>\n','cccc','2020-02-26 11:24:37','2020-03-24 18:55:29',NULL,1,'0',2,1,794,'https://ciblog.oss-cn-shanghai.aliyuncs.com/images/bg1.jpg','cccc',NULL),(134,'ddd','<p>dddd</p>\n','dddd','2020-02-26 14:17:40','2020-03-24 18:55:23',NULL,1,'0',3,1,566,'https://ciblog.oss-cn-shanghai.aliyuncs.com/images/bg1.jpg','dddd',NULL),(138,'aaa','<p>aaa</p>\n','aaa','2020-03-08 22:05:53','2020-03-24 18:55:16',NULL,1,'0',0,1,58,'https://ciblog.oss-cn-shanghai.aliyuncs.com/images/bg1.jpg','aaa',NULL),(154,'未命名文章','','','2020-03-19 14:30:45','2020-03-24 18:55:09',NULL,1,'0',0,1,75,'https://ciblog.oss-cn-shanghai.aliyuncs.com/images/bg1.jpg','',NULL),(155,'未命名文章','','','2020-03-22 15:42:48','2020-03-24 18:55:00',NULL,1,'0',0,1,259,'https://ciblog.oss-cn-shanghai.aliyuncs.com/images/bg1.jpg','',NULL),(156,'ddd','<p>dddd</p>\n','dddd','2020-03-23 20:41:49','2020-03-24 18:54:44',NULL,1,'0',2,1,253,'https://ciblog.oss-cn-shanghai.aliyuncs.com/images/bg4.jpg','dddd',NULL),(157,'asdasd','','','2020-03-25 20:09:46','2020-03-25 20:09:46',NULL,1,'0',0,1,341,'https://ciblog.oss-cn-shanghai.aliyuncs.com/images/bg1.jpg','',NULL),(158,'asdasd','<p>asdasdasd</p>\n','asdasdasd','2020-03-19 00:00:00','2020-03-26 19:07:20',NULL,1,'0',0,1,125,'https://ciblog.oss-cn-shanghai.aliyuncs.com/images/bg4.jpg','asdasdasd',NULL),(159,'大家都不电话','<p>将两个升序链表合并为一个新的升序链表并返回。新链表是通过拼接给定的两个链表的所有节点组成的。</p>\n<p>示例：<br />\n输入：1-&gt;2-&gt;4, 1-&gt;3-&gt;4<br />\n输出：1-&gt;1-&gt;2-&gt;3-&gt;4-&gt;4</p>\n<p>来源：力扣（LeetCode）<br />\n链接：https://leetcode-cn.com/problems/merge-two-sorted-lists</p>\n<blockquote>\n<p>昨天看到了这道题，于是选择先去将设计链表的题做掉了。</p>\n</blockquote>\n<pre><div class=\"hljs\"><code class=\"lang-js\"><span class=\"hljs-comment\">/**\n * Definition for singly-linked list.\n * function ListNode(val) {\n *     this.val = val;\n *     this.next = null;\n * }\n */</span>\n<span class=\"hljs-comment\">/**\n * @param {ListNode} l1\n * @param {ListNode} l2\n * @return {ListNode}\n */</span>\n<span class=\"hljs-keyword\">var</span> mergeTwoLists = <span class=\"hljs-function\"><span class=\"hljs-keyword\">function</span> (<span class=\"hljs-params\">l1, l2</span>) </span>{\n    <span class=\"hljs-comment\">//声明一个节点</span>\n    <span class=\"hljs-keyword\">var</span> head = <span class=\"hljs-keyword\">new</span> ListNode(<span class=\"hljs-number\">-1</span>);\n    <span class=\"hljs-comment\">//声明一个中间节点</span>\n    <span class=\"hljs-keyword\">var</span> flag = head;\n    <span class=\"hljs-comment\">//当两个链表都不为空的时候，进行循环</span>\n    <span class=\"hljs-keyword\">while</span> (l1 != <span class=\"hljs-literal\">null</span> &amp;&amp; l2 != <span class=\"hljs-literal\">null</span>) {\n    <span class=\"hljs-comment\">//判断两个链表第一个节点的大小</span>\n        <span class=\"hljs-keyword\">if</span> (l1.val &lt;= l2.val) {\n    <span class=\"hljs-comment\">//将中间节点的next指向第一个节点比较小的链表</span>\n            flag.next = l1;\n    <span class=\"hljs-comment\">//将l1链表向后移动一个节点，也就是把第一个节点切割出去了。因为第一个节点符合条件已经不需要循环判断了</span>\n            l1 = l1.next;\n        } <span class=\"hljs-keyword\">else</span> {\n    <span class=\"hljs-comment\">//整体思路和上一个分支一致</span>\n            flag.next = l2;\n            l2 = l2.next;\n        }\n    <span class=\"hljs-comment\">//判断之后将中间节点向后移动一位</span>\n        flag = flag.next;\n    }\n    <span class=\"hljs-comment\">//如果某个链表为null 则直接将flag.next指向另一个链表</span>\n    flag.next = l1 ? l1 : l2;\n    <span class=\"hljs-comment\">//返回head节点的next。</span>\n    <span class=\"hljs-keyword\">return</span> head.next;\n};\n\n</code></div></pre>\n<blockquote>\n<p>这道题还有一种递归的解法,真的是太简洁了<br />\n因为这个字体小写L和数字1长得实在太像了，我给改成大写的了。</p>\n</blockquote>\n<pre><div class=\"hljs\"><code class=\"lang-js\"><span class=\"hljs-comment\">/**\n* Definition for singly-linked list.\n* function ListNode(val) {\n*     this.val = val;\n*     this.next = null;\n* }\n*/</span>\n<span class=\"hljs-comment\">/**\n* @param {ListNode} L1\n* @param {ListNode} L2\n* @return {ListNode}\n*/</span>\n<span class=\"hljs-keyword\">var</span> mergeTwoLists = <span class=\"hljs-function\"><span class=\"hljs-keyword\">function</span>(<span class=\"hljs-params\">L1, L2</span>) </span>{\n    <span class=\"hljs-keyword\">if</span>(L1 == <span class=\"hljs-literal\">null</span>){\n        <span class=\"hljs-keyword\">return</span> L2;\n    }\n    <span class=\"hljs-keyword\">if</span>(L2 == <span class=\"hljs-literal\">null</span>){\n        <span class=\"hljs-keyword\">return</span> L1;\n    }\n    <span class=\"hljs-keyword\">if</span>(L1.val &lt;= L2.val){\n        L1.next = mergeTwoLists(L1.next,L2);\n        <span class=\"hljs-keyword\">return</span> L1;\n    }<span class=\"hljs-keyword\">else</span>{\n        L2.next = mergeTwoLists(L1,L2.next);\n        <span class=\"hljs-keyword\">return</span> L2;\n    }\n}\n</code></div></pre>\n','将两个升序链表合并为一个新的升序链表并返回。新链表是通过拼接给定的两个链表的所有节点组成的。 \n\n示例：\n输入：1->2->4, 1->3->4\n输出：1->1->2->3->4->4\n\n来源：力扣（LeetCode）\n链接：https://leetcode-cn.com/problems/merge-two-sorted-lists\n\n> 昨天看到了这道题，于是选择先去将设计链表的题做掉了。\n\n```js\n/**\n * Definition for singly-linked list.\n * function ListNode(val) {\n *     this.val = val;\n *     this.next = null;\n * }\n */\n/**\n * @param {ListNode} l1\n * @param {ListNode} l2\n * @return {ListNode}\n */\nvar mergeTwoLists = function (l1, l2) {\n    //声明一个节点\n    var head = new ListNode(-1);\n    //声明一个中间节点\n    var flag = head;\n    //当两个链表都不为空的时候，进行循环\n    while (l1 != null && l2 != null) {\n    //判断两个链表第一个节点的大小\n        if (l1.val <= l2.val) {\n    //将中间节点的next指向第一个节点比较小的链表\n            flag.next = l1;\n    //将l1链表向后移动一个节点，也就是把第一个节点切割出去了。因为第一个节点符合条件已经不需要循环判断了\n            l1 = l1.next;\n        } else {\n    //整体思路和上一个分支一致\n            flag.next = l2;\n            l2 = l2.next;\n        }\n    //判断之后将中间节点向后移动一位\n        flag = flag.next;\n    }\n    //如果某个链表为null 则直接将flag.next指向另一个链表\n    flag.next = l1 ? l1 : l2;\n    //返回head节点的next。\n    return head.next;\n};\n\n```\n\n> 这道题还有一种递归的解法,真的是太简洁了\n> 因为这个字体小写L和数字1长得实在太像了，我给改成大写的了。\n\n```js\n/**\n* Definition for singly-linked list.\n* function ListNode(val) {\n*     this.val = val;\n*     this.next = null;\n* }\n*/\n/**\n* @param {ListNode} L1\n* @param {ListNode} L2\n* @return {ListNode}\n*/\nvar mergeTwoLists = function(L1, L2) {\n    if(L1 == null){\n        return L2;\n    }\n    if(L2 == null){\n        return L1;\n    }\n    if(L1.val <= L2.val){\n        L1.next = mergeTwoLists(L1.next,L2);\n        return L1;\n    }else{\n        L2.next = mergeTwoLists(L1,L2.next);\n        return L2;\n    }\n}\n```\n\n','2020-04-08 22:32:49','2020-04-15 17:07:58',NULL,1,'0',1,1,452,'https://ciblog.oss-cn-shanghai.aliyuncs.com/images/bg1.jpg','将两个升序链表合并为一个新的升序链表并返回。新链表是通过拼接给定的两个链表的所有节点组成的。 \n\n示例：\n输入：124, 134\n输出：112344\n\n来源：力扣（LeetCode）\n链接：https',NULL);
/*!40000 ALTER TABLE `ciblog_article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ciblog_article_meta`
--

DROP TABLE IF EXISTS `ciblog_article_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ciblog_article_meta` (
  `id` int(50) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `mid` int(11) DEFAULT NULL COMMENT '标签或分类主键',
  `aid` int(11) DEFAULT NULL COMMENT '文章主键',
  `type` varchar(20) DEFAULT NULL COMMENT '类型',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `article` (`aid`) USING BTREE,
  KEY `meta` (`mid`) USING BTREE,
  CONSTRAINT `article` FOREIGN KEY (`aid`) REFERENCES `ciblog_article` (`aid`) ON DELETE CASCADE,
  CONSTRAINT `meta` FOREIGN KEY (`mid`) REFERENCES `ciblog_meta` (`mid`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=788 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ciblog_article_meta`
--

LOCK TABLES `ciblog_article_meta` WRITE;
/*!40000 ALTER TABLE `ciblog_article_meta` DISABLE KEYS */;
INSERT INTO `ciblog_article_meta` VALUES (738,158,156,'category'),(739,161,156,'category'),(740,164,156,'category'),(741,166,156,'category'),(742,167,156,'category'),(744,127,156,'tag'),(745,145,156,'tag'),(747,158,155,'category'),(748,164,155,'category'),(749,166,155,'category'),(750,158,154,'category'),(751,163,154,'category'),(752,166,154,'category'),(753,172,154,'tag'),(754,145,154,'tag'),(755,131,154,'tag'),(756,163,138,'category'),(757,165,138,'category'),(758,158,134,'category'),(759,161,134,'category'),(760,162,134,'category'),(761,163,134,'category'),(762,164,134,'category'),(763,165,134,'category'),(764,166,134,'category'),(765,167,134,'category'),(766,127,134,'tag'),(767,158,133,'category'),(768,163,133,'category'),(769,165,133,'category'),(770,167,133,'category'),(771,127,133,'tag'),(772,158,157,'category'),(773,173,157,'tag'),(775,158,158,'category'),(785,163,159,'category'),(786,164,159,'category'),(787,131,159,'tag');
/*!40000 ALTER TABLE `ciblog_article_meta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ciblog_comment`
--

DROP TABLE IF EXISTS `ciblog_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ciblog_comment` (
  `cid` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `ip` varchar(100) DEFAULT NULL COMMENT 'ip地址',
  `content` longtext DEFAULT NULL COMMENT '评论内容',
  `nickname` varchar(50) DEFAULT NULL COMMENT '昵称',
  `email` varchar(50) DEFAULT NULL COMMENT '邮箱',
  `aid` int(11) DEFAULT NULL COMMENT '文章id',
  `status` int(11) DEFAULT NULL COMMENT '0-未审核\r\n1-通过\r\n2-垃圾',
  `reply` varchar(150) DEFAULT NULL COMMENT '回复的评论id 以及昵称',
  `create_date` datetime DEFAULT NULL COMMENT '评论时间',
  `client` varchar(100) DEFAULT NULL COMMENT '客户端信息',
  `avatar_url` varchar(100) DEFAULT NULL COMMENT '头像链接',
  PRIMARY KEY (`cid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=259 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ciblog_comment`
--

LOCK TABLES `ciblog_comment` WRITE;
/*!40000 ALTER TABLE `ciblog_comment` DISABLE KEYS */;
INSERT INTO `ciblog_comment` VALUES (192,'127.0.0.1','好呀','大大大','15204944127@qq.com',134,1,NULL,'2020-02-27 13:59:44',NULL,''),(193,'127.0.0.1','不太好','小小小','15204944127@163.com',134,1,'{\"cid\":192,\"nickname\":\"\\u5927\\u5927\\u5927\"}','2020-02-27 14:00:03',NULL,''),(204,'127.0.0.1','嘿嘿嘿','ddd','123@qq.com',134,0,'{\"cid\":193,\"nickname\":\"\\u5c0f\\u5c0f\\u5c0f\"}','2020-02-28 19:49:37',NULL,''),(235,'127.0.0.1','asdasd','sddasd','sd@qq.com',134,1,'{\"cid\":193,\"nickname\":\"\\u5c0f\\u5c0f\\u5c0f\"}','2020-03-07 22:10:59',NULL,''),(254,'127.0.0.1','aaaaa','aaa','aaa@aaa.com',156,1,NULL,'2020-03-24 17:33:24',NULL,''),(255,'127.0.0.1','heiheibei','还长啥','14dd9@qq.com',133,1,NULL,'2020-04-04 21:17:46',NULL,''),(256,'127.0.0.1','ddds','还长啥','14dd9@qq.com',133,1,NULL,'2020-04-04 21:17:59',NULL,''),(257,'127.0.0.1','dasd','aaaaa','sada@qqq.comas',156,1,'{\"cid\":254,\"nickname\":\"aaa\"}','2020-04-13 23:59:35',NULL,''),(258,'127.0.0.1','dasd','asd','asd@asd.com',159,1,NULL,'2020-04-18 21:29:14',NULL,'');
/*!40000 ALTER TABLE `ciblog_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ciblog_file`
--

DROP TABLE IF EXISTS `ciblog_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ciblog_file` (
  `fid` int(11) NOT NULL AUTO_INCREMENT COMMENT '文件主键',
  `name` varchar(255) DEFAULT NULL COMMENT '文件名',
  `type` varchar(50) DEFAULT NULL COMMENT '文件类型',
  `url` varchar(255) DEFAULT NULL COMMENT '文件url',
  `size` int(11) DEFAULT NULL COMMENT '文件大小',
  `aid` int(11) DEFAULT NULL COMMENT '所属文章id',
  `datetime` datetime DEFAULT NULL COMMENT '上传时间',
  `status` varchar(11) DEFAULT NULL COMMENT '0-归档文件\r\n1-临时文件\r\n2-全局文件',
  `path` varchar(255) DEFAULT NULL COMMENT '文件路径',
  PRIMARY KEY (`fid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=174 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ciblog_file`
--

LOCK TABLES `ciblog_file` WRITE;
/*!40000 ALTER TABLE `ciblog_file` DISABLE KEYS */;
INSERT INTO `ciblog_file` VALUES (168,'1d890c105ccac17fae1901c977687f1b.jpg','image/jpeg','http://127.0.0.1/api/public/uploads/20200420/dd6cbe8b2440c9e7eba95b01230001f8.jpg',187643,-2,'2020-04-20 17:08:27','2','20200420/dd6cbe8b2440c9e7eba95b01230001f8.jpg'),(169,'ea41cb48c796ffd3020514994fc3e839.jpg','image/jpeg','http://127.0.0.1/api/public/uploads/20200420/bd6e80c8ce4ab7b8e6c2987eda44ab64.jpg',137146,-2,'2020-04-20 17:08:52','2','20200420/bd6e80c8ce4ab7b8e6c2987eda44ab64.jpg'),(172,'ea41cb48c796ffd3020514994fc3e839.jpg','image/jpeg','http://127.0.0.1/api/public/uploads/20200420/9c118227b1018d92065acf3c572711be.jpg',137146,159,'2020-04-20 17:43:59','0','20200420/9c118227b1018d92065acf3c572711be.jpg'),(173,'timg.jpg','image/jpeg','http://127.0.0.1/api/public/uploads/20200420/3f579183e4176e657bd3882507d5a366.jpg',222007,159,'2020-04-20 18:39:55','0','20200420/3f579183e4176e657bd3882507d5a366.jpg');
/*!40000 ALTER TABLE `ciblog_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ciblog_meta`
--

DROP TABLE IF EXISTS `ciblog_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ciblog_meta` (
  `mid` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(50) NOT NULL COMMENT '分类或标签名称',
  `type` varchar(50) NOT NULL COMMENT 'tag或者category\r\n',
  `description` varchar(50) DEFAULT NULL COMMENT '描述',
  `count` int(11) DEFAULT 0 COMMENT '使用该标签的文章数',
  `order` int(10) DEFAULT 0 COMMENT '分类排序  tag为0',
  `parent` int(10) DEFAULT NULL COMMENT '二级分类',
  PRIMARY KEY (`mid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=174 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ciblog_meta`
--

LOCK TABLES `ciblog_meta` WRITE;
/*!40000 ALTER TABLE `ciblog_meta` DISABLE KEYS */;
INSERT INTO `ciblog_meta` VALUES (127,'aaa','tag',NULL,0,0,0),(131,'ccc','tag',NULL,0,0,0),(145,'asd','tag',NULL,0,0,0),(158,'aaa','category','gvghvg',0,0,0),(161,'bbb','category','bbb',0,0,NULL),(162,'ccc','category','ccc',0,0,NULL),(163,'ddd','category','ddd',0,0,NULL),(164,'eee','category','eee',0,0,NULL),(165,'fff','category','ffff',0,0,NULL),(166,'ggg','category','ggg',0,0,NULL),(167,'hhh','category','hhh',0,0,NULL),(169,'aa','tag',NULL,0,0,0),(171,'dsad','tag',NULL,0,0,0),(172,'asdasdsadas','tag',NULL,0,0,0),(173,'xxxx','tag',NULL,0,0,0);
/*!40000 ALTER TABLE `ciblog_meta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ciblog_setup`
--

DROP TABLE IF EXISTS `ciblog_setup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ciblog_setup` (
  `name` varchar(255) DEFAULT NULL COMMENT '设置名称',
  `user` int(50) DEFAULT NULL COMMENT '所属用户',
  `value` longtext DEFAULT NULL COMMENT '设置值'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ciblog_setup`
--

LOCK TABLES `ciblog_setup` WRITE;
/*!40000 ALTER TABLE `ciblog_setup` DISABLE KEYS */;
INSERT INTO `ciblog_setup` VALUES ('banner',1,'https://ciblog.oss-cn-shanghai.aliyuncs.com/images/bg1.jpg\nhttps://ciblog.oss-cn-shanghai.aliyuncs.com/images/bg2.jpg\nhttps://ciblog.oss-cn-shanghai.aliyuncs.com/images/bg3.jpg\nhttps://ciblog.oss-cn-shanghai.aliyuncs.com/images/bg4.jpg'),('comment_check',1,''),('qaq',1,'QAQ%OwQ%(/= _ =)/~┴┴%（●>∀<●）%(→_←)%ヾ(=^▽^=)ノ%(*￣∇￣*)%(*´∇｀*)%(*ﾟ▽ﾟ*)%(｡･ω･)ﾉﾞ%(≡ω≡．)%(｀･ω･´)%(´･ω･｀)%(●´ω｀●)φ%'),('web_description',1,'奇迹每天都在发生，只是你不觉得它是奇迹罢了。'),('default_category',1,'158'),('web_url',1,'http://localhost:8020/'),('web_name',1,'猫不理の锅包肉'),('comment_is_allow',1,'1'),('nav_configuration',1,'{\n    \"text\": \"bilibili\",\n    \"href\": \"https://space.bilibili.com/4568935/\",\n    \"icon\": \"iconfont icon-aria-about\"\n},\n{\n    \"text\": \"git\",\n    \"href\": \"https://github.com/zhangyifei233\",\n    \"icon\": \"iconfont icon-aria-github\"\n},\n{\n    \"text\": \"博客\",\n    \"linkto\": \"/\",\n    \"icon\": \"iconfont icon-aria-home\",\n    \"sub\": [\n        {\n            \"text\": \"ddd\",\n            \"linkto\": \"/search/category/163\",\n            \"icon\": \"iconfont icon-aria-music\"\n        }\n    ]\n},\n{\n    \"text\": \"归档\",\n    \"linkto\": \"/log\",\n    \"icon\": \"iconfont icon-aria-archives\"\n}'),('top_article',1,'159');
/*!40000 ALTER TABLE `ciblog_setup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ciblog_user`
--

DROP TABLE IF EXISTS `ciblog_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ciblog_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id\r\n\r\n',
  `name` varchar(50) DEFAULT NULL COMMENT '用户姓名',
  `password` varchar(200) DEFAULT NULL COMMENT '用户密码',
  `mail` varchar(50) DEFAULT NULL COMMENT '用户邮箱',
  `bilibili` varchar(50) DEFAULT NULL COMMENT '用户哔哩哔哩（url地址）',
  `github` varchar(50) DEFAULT NULL COMMENT '用户github（rul地址）',
  `nickname` varchar(20) DEFAULT NULL COMMENT '用户昵称',
  `group_id` int(50) DEFAULT NULL COMMENT '用户组',
  `imgurl` varchar(200) DEFAULT NULL COMMENT '头像地址',
  `description` varchar(100) DEFAULT NULL COMMENT '个人描述',
  PRIMARY KEY (`uid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ciblog_user`
--

LOCK TABLES `ciblog_user` WRITE;
/*!40000 ALTER TABLE `ciblog_user` DISABLE KEYS */;
INSERT INTO `ciblog_user` VALUES (1,'admin','9d1ba4b3ecc9964684a5dc63d0b0f1a4','15204944127@163.com','https://space.bilibili.com/4568935','https://github.com/zhangyifei233','猫不理的锅包肉',0,'https://xiaochengxuimg.oss-cn-beijing.aliyuncs.com/Blog/oh.jpg','奇迹每天都在发生，只是你不觉得它是奇迹罢了。'),(2,'testadmin','21232f297a57a5a743894a0e4a801fc3','15204944127@163.com','https://space.bilibili.com/4568935','https://github.com/zhangyifei233','预览账号',0,'https://xiaochengxuimg.oss-cn-beijing.aliyuncs.com/Blog/oh.jpg','预览个人描述');
/*!40000 ALTER TABLE `ciblog_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-04-21 18:32:13
