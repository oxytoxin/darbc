SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for barangays
-- ----------------------------
DROP TABLE IF EXISTS `barangays`;
CREATE TABLE `barangays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `description` text,
  `region_code` varchar(255) DEFAULT NULL,
  `province_code` varchar(255) DEFAULT NULL,
  `city_code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42030 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of barangays
-- ----------------------------
INSERT INTO `barangays` VALUES ('1', '012801001', 'Adams (Pob.)', '01', '0128', '012801');
INSERT INTO `barangays` VALUES ('2', '012802001', 'Bani', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('3', '012802002', 'Buyon', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('4', '012802003', 'Cabaruan', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('5', '012802004', 'Cabulalaan', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('6', '012802005', 'Cabusligan', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('7', '012802006', 'Cadaratan', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('8', '012802007', 'Calioet-Libong', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('9', '012802008', 'Casilian', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('10', '012802009', 'Corocor', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('11', '012802011', 'Duripes', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('12', '012802012', 'Ganagan', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('13', '012802013', 'Libtong', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('14', '012802014', 'Macupit', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('15', '012802015', 'Nambaran', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('16', '012802016', 'Natba', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('17', '012802017', 'Paninaan', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('18', '012802018', 'Pasiocan', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('19', '012802019', 'Pasngal', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('20', '012802020', 'Pipias', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('21', '012802021', 'Pulangi', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('22', '012802022', 'Pungto', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('23', '012802024', 'San Agustin I (Pob.)', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('24', '012802025', 'San Agustin II (Pob.)', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('25', '012802027', 'San Andres I (Pob.)', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('26', '012802028', 'San Andres II (Pob.)', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('27', '012802030', 'San Gabriel I (Pob.)', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('28', '012802031', 'San Gabriel II (Pob.)', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('29', '012802033', 'San Pedro I (Pob.)', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('30', '012802034', 'San Pedro II (Pob.)', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('31', '012802036', 'San Roque I (Pob.)', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('32', '012802037', 'San Roque II (Pob.)', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('33', '012802039', 'San Simon I (Pob.)', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('34', '012802040', 'San Simon II (Pob.)', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('35', '012802041', 'San Vicente (Pob.)', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('36', '012802042', 'Sangil', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('37', '012802044', 'Santa Filomena I (Pob.)', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('38', '012802045', 'Santa Filomena II (Pob.)', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('39', '012802046', 'Santa Rita (Pob.)', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('40', '012802047', 'Santo Cristo I (Pob.)', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('41', '012802048', 'Santo Cristo II (Pob.)', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('42', '012802050', 'Tambidao', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('43', '012802051', 'Teppang', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('44', '012802052', 'Tubburan', '01', '0128', '012802');
INSERT INTO `barangays` VALUES ('45', '012803001', 'Alay-Nangbabaan (Alay 15-B)', '01', '0128', '012803');
INSERT INTO `barangays` VALUES ('46', '012803002', 'Alogoog', '01', '0128', '012803');
INSERT INTO `barangays` VALUES ('47', '012803003', 'Ar-arusip', '01', '0128', '012803');
INSERT INTO `barangays` VALUES ('48', '012803004', 'Aring', '01', '0128', '012803');
INSERT INTO `barangays` VALUES ('49', '012803005', 'Balbaldez', '01', '0128', '012803');
INSERT INTO `barangays` VALUES ('50', '012803006', 'Bato', '01', '0128', '012803');
INSERT INTO `barangays` VALUES ('51', '012803007', 'Camanga', '01', '0128', '012803');
INSERT INTO `barangays` VALUES ('52', '012803008', 'Canaan (Pob.)', '01', '0128', '012803');
INSERT INTO `barangays` VALUES ('53', '012803009', 'Caraitan', '01', '0128', '012803');
INSERT INTO `barangays` VALUES ('54', '012803011', 'Gabut Norte', '01', '0128', '012803');
INSERT INTO `barangays` VALUES ('55', '012803012', 'Gabut Sur', '01', '0128', '012803');
INSERT INTO `barangays` VALUES ('56', '012803013', 'Garreta (Pob.)', '01', '0128', '012803');
INSERT INTO `barangays` VALUES ('57', '012803016', 'Labut', '01', '0128', '012803');
INSERT INTO `barangays` VALUES ('58', '012803017', 'Lacuben', '01', '0128', '012803');
INSERT INTO `barangays` VALUES ('59', '012803018', 'Lubigan', '01', '0128', '012803');
INSERT INTO `barangays` VALUES ('60', '012803020', 'Mabusag Norte', '01', '0128', '012803');
INSERT INTO `barangays` VALUES ('61', '012803021', 'Mabusag Sur', '01', '0128', '012803');
INSERT INTO `barangays` VALUES ('62', '012803022', 'Madupayas', '01', '0128', '012803');
INSERT INTO `barangays` VALUES ('63', '012803023', 'Morong', '01', '0128', '012803');
INSERT INTO `barangays` VALUES ('64', '012803025', 'Nagrebcan', '01', '0128', '012803');
INSERT INTO `barangays` VALUES ('65', '012803026', 'Napu', '01', '0128', '012803');
INSERT INTO `barangays` VALUES ('66', '012803027', 'La Virgen Milagrosa (Paguetpet)', '01', '0128', '012803');
INSERT INTO `barangays` VALUES ('67', '012803028', 'Pagsanahan Norte', '01', '0128', '012803');
INSERT INTO `barangays` VALUES ('68', '012803029', 'Pagsanahan Sur', '01', '0128', '012803');
INSERT INTO `barangays` VALUES ('69', '012803030', 'Paltit', '01', '0128', '012803');
INSERT INTO `barangays` VALUES ('70', '012803031', 'Parang', '01', '0128', '012803');
INSERT INTO `barangays` VALUES ('71', '012803032', 'Pasuc', '01', '0128', '012803');
INSERT INTO `barangays` VALUES ('72', '012803034', 'Santa Cruz Norte', '01', '0128', '012803');
INSERT INTO `barangays` VALUES ('73', '012803035', 'Santa Cruz Sur', '01', '0128', '012803');
INSERT INTO `barangays` VALUES ('74', '012803036', 'Saud', '01', '0128', '012803');
INSERT INTO `barangays` VALUES ('75', '012803037', 'Turod', '01', '0128', '012803');
INSERT INTO `barangays` VALUES ('76', '012804001', 'Abaca', '01', '0128', '012804');
INSERT INTO `barangays` VALUES ('77', '012804002', 'Bacsil', '01', '0128', '012804');
INSERT INTO `barangays` VALUES ('78', '012804003', 'Banban', '01', '0128', '012804');
INSERT INTO `barangays` VALUES ('79', '012804004', 'Baruyen', '01', '0128', '012804');
INSERT INTO `barangays` VALUES ('80', '012804005', 'Dadaor', '01', '0128', '012804');
INSERT INTO `barangays` VALUES ('81', '012804006', 'Lanao', '01', '0128', '012804');
