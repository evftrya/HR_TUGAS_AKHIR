<?php

namespace Database\Seeders;

use App\Models\RefSubKelompokKeahlian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RefSubKelompokKeahlianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data =

            [
                /* A. FAKULTAS TEKNIK ELEKTRO */
                /* KK Transmisi Telekomunikasi */
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600001", "nama" => "Analog Communications", "kode" => "AC", "deskripsi" => "-", "kk_id" => "672957e1-8557-4f6c-8515-b777a1122a01"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600002", "nama" => "Digital Communications", "kode" => "DC", "deskripsi" => "-", "kk_id" => "672957e1-8557-4f6c-8515-b777a1122a01"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600003", "nama" => "Communication Electronics", "kode" => "CE", "deskripsi" => "-", "kk_id" => "672957e1-8557-4f6c-8515-b777a1122a01"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600004", "nama" => "Antenna", "kode" => "ANT", "deskripsi" => "-", "kk_id" => "672957e1-8557-4f6c-8515-b777a1122a01"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600005", "nama" => "Radio Propagation", "kode" => "RP", "deskripsi" => "-", "kk_id" => "672957e1-8557-4f6c-8515-b777a1122a01"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600006", "nama" => "Mobile Communications", "kode" => "MC", "deskripsi" => "-", "kk_id" => "672957e1-8557-4f6c-8515-b777a1122a01"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600007", "nama" => "Optical Communications", "kode" => "OC", "deskripsi" => "-", "kk_id" => "672957e1-8557-4f6c-8515-b777a1122a01"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600008", "nama" => "Satellite Communications", "kode" => "SC", "deskripsi" => "-", "kk_id" => "672957e1-8557-4f6c-8515-b777a1122a01"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600009", "nama" => "Radio Engineering", "kode" => "RE", "deskripsi" => "-", "kk_id" => "672957e1-8557-4f6c-8515-b777a1122a01"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600010", "nama" => "Microwave Engineering", "kode" => "ME", "deskripsi" => "-", "kk_id" => "672957e1-8557-4f6c-8515-b777a1122a01"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600011", "nama" => "Cable Wireline Communications", "kode" => "CWC", "deskripsi" => "-", "kk_id" => "672957e1-8557-4f6c-8515-b777a1122a01"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600012", "nama" => "RADAR", "kode" => "RADAR", "deskripsi" => "-", "kk_id" => "672957e1-8557-4f6c-8515-b777a1122a01"],

                /* KK Jaringan Multimedia */
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600013", "nama" => "Ad Hoc Network", "kode" => "AHN", "deskripsi" => "-", "kk_id" => "f58f793b-967a-4934-9276-805175936496"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600014", "nama" => "SDN", "kode" => "SDN", "deskripsi" => "-", "kk_id" => "f58f793b-967a-4934-9276-805175936496"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600015", "nama" => "Multimedia Communication", "kode" => "MCOM", "deskripsi" => "-", "kk_id" => "f58f793b-967a-4934-9276-805175936496"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600016", "nama" => "Broadband Network", "kode" => "BN", "deskripsi" => "-", "kk_id" => "f58f793b-967a-4934-9276-805175936496"],

                /* KK Rekayasa Komputer */
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600017", "nama" => "Sistem Komputer", "kode" => "SK", "deskripsi" => "-", "kk_id" => "04c10557-0744-460d-8549-36879815049b"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600018", "nama" => "Perangkat Keras (HW)", "kode" => "HW", "deskripsi" => "-", "kk_id" => "04c10557-0744-460d-8549-36879815049b"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600019", "nama" => "Perangkat Lunak (SW)", "kode" => "SW", "deskripsi" => "-", "kk_id" => "04c10557-0744-460d-8549-36879815049b"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600020", "nama" => "Jaringan Komputer", "kode" => "JK", "deskripsi" => "-", "kk_id" => "04c10557-0744-460d-8549-36879815049b"],

                /* KK Pengolahan Sinyal Informasi */
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600021", "nama" => "Signal Processing", "kode" => "SP", "deskripsi" => "-", "kk_id" => "b309605d-2b47-4144-8025-067823528859"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600022", "nama" => "Speech & Image Processing", "kode" => "SIP", "deskripsi" => "-", "kk_id" => "b309605d-2b47-4144-8025-067823528859"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600023", "nama" => "Steganography", "kode" => "STEG", "deskripsi" => "-", "kk_id" => "b309605d-2b47-4144-8025-067823528859"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600024", "nama" => "Smart Grid", "kode" => "SG", "deskripsi" => "-", "kk_id" => "b309605d-2b47-4144-8025-067823528859"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600025", "nama" => "Coding Compression", "kode" => "CC", "deskripsi" => "-", "kk_id" => "b309605d-2b47-4144-8025-067823528859"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600026", "nama" => "Information and Coding", "kode" => "IC", "deskripsi" => "-", "kk_id" => "b309605d-2b47-4144-8025-067823528859"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600027", "nama" => "Software & Mobile Application", "kode" => "SMA-PSI", "deskripsi" => "-", "kk_id" => "b309605d-2b47-4144-8025-067823528859"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600028", "nama" => "Watermarking", "kode" => "WM", "deskripsi" => "-", "kk_id" => "b309605d-2b47-4144-8025-067823528859"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600029", "nama" => "Medical Image Processing", "kode" => "MIP", "deskripsi" => "-", "kk_id" => "b309605d-2b47-4144-8025-067823528859"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600030", "nama" => "Biosignal Processing", "kode" => "BP", "deskripsi" => "-", "kk_id" => "b309605d-2b47-4144-8025-067823528859"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600031", "nama" => "Steganalysis", "kode" => "STANAL", "deskripsi" => "-", "kk_id" => "b309605d-2b47-4144-8025-067823528859"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600032", "nama" => "Machine Learning", "kode" => "ML", "deskripsi" => "-", "kk_id" => "b309605d-2b47-4144-8025-067823528859"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600033", "nama" => "Compresive Sensing", "kode" => "CS-PSI", "deskripsi" => "-", "kk_id" => "b309605d-2b47-4144-8025-067823528859"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600034", "nama" => "Radar Communication", "kode" => "RC", "deskripsi" => "-", "kk_id" => "b309605d-2b47-4144-8025-067823528859"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600035", "nama" => "Computer vision & graphics", "kode" => "CVG", "deskripsi" => "-", "kk_id" => "b309605d-2b47-4144-8025-067823528859"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600036", "nama" => "Virtual reality", "kode" => "VR", "deskripsi" => "-", "kk_id" => "b309605d-2b47-4144-8025-067823528859"],

                /* KK Sistem Elektronika */
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600037", "nama" => "Teknik Pengaturan", "kode" => "TP", "deskripsi" => "-", "kk_id" => "8032734a-939b-4e63-8822-632342557765"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600038", "nama" => "Rangkaian Listrik", "kode" => "RL", "deskripsi" => "-", "kk_id" => "8032734a-939b-4e63-8822-632342557765"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600039", "nama" => "Elektronika analog", "kode" => "EA", "deskripsi" => "-", "kk_id" => "8032734a-939b-4e63-8822-632342557765"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600040", "nama" => "Rangkaian digital", "kode" => "RD", "deskripsi" => "-", "kk_id" => "8032734a-939b-4e63-8822-632342557765"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600041", "nama" => "Perancangan PCB", "kode" => "PCB", "deskripsi" => "-", "kk_id" => "8032734a-939b-4e63-8822-632342557765"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600042", "nama" => "Teknik penyolderan SMD", "kode" => "SMD-SEL", "deskripsi" => "-", "kk_id" => "8032734a-939b-4e63-8822-632342557765"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600043", "nama" => "Pengolahan sinyal", "kode" => "PS", "deskripsi" => "-", "kk_id" => "8032734a-939b-4e63-8822-632342557765"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600044", "nama" => "Otomatisasi Industri", "kode" => "OI", "deskripsi" => "-", "kk_id" => "8032734a-939b-4e63-8822-632342557765"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600045", "nama" => "Mekatronika", "kode" => "MEK", "deskripsi" => "-", "kk_id" => "8032734a-939b-4e63-8822-632342557765"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600046", "nama" => "Programming", "kode" => "PROG-SEL", "deskripsi" => "-", "kk_id" => "8032734a-939b-4e63-8822-632342557765"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600047", "nama" => "Mikrokontroller", "kode" => "MKR", "deskripsi" => "-", "kk_id" => "8032734a-939b-4e63-8822-632342557765"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600048", "nama" => "Mikroprosesor", "kode" => "MPR", "deskripsi" => "-", "kk_id" => "8032734a-939b-4e63-8822-632342557765"],

                /* KK Rekayasa Instrumentasi dan Energi */
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600049", "nama" => "Energi terbarukan", "kode" => "ET", "deskripsi" => "-", "kk_id" => "d0408518-8684-4863-8865-884812300091"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600050", "nama" => "Instrumentasi dan kontrol", "kode" => "IK", "deskripsi" => "-", "kk_id" => "d0408518-8684-4863-8865-884812300091"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600051", "nama" => "Material dan devices", "kode" => "MD", "deskripsi" => "-", "kk_id" => "d0408518-8684-4863-8865-884812300091"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600052", "nama" => "Akustik dan signal processing", "kode" => "ASP-RIE", "deskripsi" => "-", "kk_id" => "d0408518-8684-4863-8865-884812300091"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600053", "nama" => "Termal", "kode" => "TRM", "deskripsi" => "-", "kk_id" => "d0408518-8684-4863-8865-884812300091"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600054", "nama" => "Fisika bangunan", "kode" => "FB", "deskripsi" => "-", "kk_id" => "d0408518-8684-4863-8865-884812300091"],

                /* B. FAKULTAS REKAYASA INDUSTRI */
                /* KK e-Process and Work System Optimization */
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600055", "nama" => "Product Design and Ergonomi", "kode" => "PDE", "deskripsi" => "-", "kk_id" => "67324831-5079-4301-8314-112347596012"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600056", "nama" => "Production process and Automation", "kode" => "PPA", "deskripsi" => "-", "kk_id" => "67324831-5079-4301-8314-112347596012"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600057", "nama" => "Maintenance Management", "kode" => "MM", "deskripsi" => "-", "kk_id" => "67324831-5079-4301-8314-112347596012"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600058", "nama" => "Quality System Engineering", "kode" => "QSE", "deskripsi" => "-", "kk_id" => "67324831-5079-4301-8314-112347596012"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600059", "nama" => "ERP Supply Chain", "kode" => "ERP-SC", "deskripsi" => "-", "kk_id" => "67324831-5079-4301-8314-112347596012"],

                /* KK e-Engineering Management */
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600060", "nama" => "Engineering Management", "kode" => "EM", "deskripsi" => "-", "kk_id" => "31248067-1011-4467-9122-340679812456"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600061", "nama" => "Financial Engineering", "kode" => "FE", "deskripsi" => "-", "kk_id" => "31248067-1011-4467-9122-340679812456"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600062", "nama" => "Project Management", "kode" => "PM", "deskripsi" => "-", "kk_id" => "31248067-1011-4467-9122-340679812456"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600063", "nama" => "Marketing", "kode" => "MKT-EEM", "deskripsi" => "-", "kk_id" => "31248067-1011-4467-9122-340679812456"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600064", "nama" => "Business Analysis", "kode" => "BA-EEM", "deskripsi" => "-", "kk_id" => "31248067-1011-4467-9122-340679812456"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600065", "nama" => "Human Capital", "kode" => "HC", "deskripsi" => "-", "kk_id" => "31248067-1011-4467-9122-340679812456"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600066", "nama" => "Enterpreneurship", "kode" => "ENTR", "deskripsi" => "-", "kk_id" => "31248067-1011-4467-9122-340679812456"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600067", "nama" => "Teknologi Manajemen", "kode" => "TM", "deskripsi" => "-", "kk_id" => "31248067-1011-4467-9122-340679812456"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600068", "nama" => "ICT Regulation", "kode" => "IREG", "deskripsi" => "-", "kk_id" => "31248067-1011-4467-9122-340679812456"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600069", "nama" => "Sistem Industri", "kode" => "SI-EEM", "deskripsi" => "-", "kk_id" => "31248067-1011-4467-9122-340679812456"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600070", "nama" => "Ekonomi Industri", "kode" => "EI", "deskripsi" => "-", "kk_id" => "31248067-1011-4467-9122-340679812456"],

                /* KK e-System Development */
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600071", "nama" => "Sistem Informasi", "kode" => "SI-ESD", "deskripsi" => "-", "kk_id" => "55091244-8891-4122-9901-561239845712"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600072", "nama" => "Computation, Heuristic Methom", "kode" => "CHM", "deskripsi" => "-", "kk_id" => "55091244-8891-4122-9901-561239845712"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600073", "nama" => "Optimization", "kode" => "OPT", "deskripsi" => "-", "kk_id" => "55091244-8891-4122-9901-561239845712"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600074", "nama" => "Data Mining", "kode" => "DM", "deskripsi" => "-", "kk_id" => "55091244-8891-4122-9901-561239845712"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600075", "nama" => "Enterprise Architechture Planning", "kode" => "EAP", "deskripsi" => "-", "kk_id" => "55091244-8891-4122-9901-561239845712"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600076", "nama" => "Software Modeling and Design", "kode" => "SMD-ESD", "deskripsi" => "-", "kk_id" => "55091244-8891-4122-9901-561239845712"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600077", "nama" => "Intelligent System and Pervasive Computing", "kode" => "ISPC", "deskripsi" => "-", "kk_id" => "55091244-8891-4122-9901-561239845712"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600078", "nama" => "Multiagent System and Internet of Things", "kode" => "MSIOT", "deskripsi" => "-", "kk_id" => "55091244-8891-4122-9901-561239845712"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600079", "nama" => "Software Engineering", "kode" => "SE-ESD", "deskripsi" => "-", "kk_id" => "55091244-8891-4122-9901-561239845712"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600080", "nama" => "Web Application Development", "kode" => "WAD", "deskripsi" => "-", "kk_id" => "55091244-8891-4122-9901-561239845712"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600081", "nama" => "Digital Marketing", "kode" => "DMKT", "deskripsi" => "-", "kk_id" => "55091244-8891-4122-9901-561239845712"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600082", "nama" => "Service Oriented Architechture", "kode" => "SOA", "deskripsi" => "-", "kk_id" => "55091244-8891-4122-9901-561239845712"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600083", "nama" => "IT Project Management", "kode" => "ITPM", "deskripsi" => "-", "kk_id" => "55091244-8891-4122-9901-561239845712"],

                /* KK e-Solution and Assurance */
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600084", "nama" => "Enterprise Infrastructure Management (EIM)", "kode" => "EIM", "deskripsi" => "-", "kk_id" => "99102345-6678-4122-8812-771239456789"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600085", "nama" => "Enterprise Resource Planning (ERP)", "kode" => "ERP", "deskripsi" => "-", "kk_id" => "99102345-6678-4122-8812-771239456789"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600086", "nama" => "Enterprise Architecture Architecting (EAA)", "kode" => "EAA", "deskripsi" => "-", "kk_id" => "99102345-6678-4122-8812-771239456789"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600087", "nama" => "IT GRC (Governance, Risk and Compliance)", "kode" => "ITGRC", "deskripsi" => "-", "kk_id" => "99102345-6678-4122-8812-771239456789"],

                /* C. FAKULTAS INFORMATIKA */
                /* KK Intelligent, Computing and Multimedia */
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600088", "nama" => "Pengkajian mengenai estetika Informatika", "kode" => "ESTET", "deskripsi" => "Intellegensia, Computing, dan Multimedia", "kk_id" => "41234567-8901-4122-b123-c12345678901"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600089", "nama" => "Penelitian ICM", "kode" => "P-ICM", "deskripsi" => "Hak paten maupun publikasi nasional/internasional", "kk_id" => "41234567-8901-4122-b123-c12345678901"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600090", "nama" => "Kompetensi Intelegensia", "kode" => "K-INTEL", "deskripsi" => "Memperkaya wawasan keilmuan informatika", "kk_id" => "41234567-8901-4122-b123-c12345678901"],

                /* KK Telematics */
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600091", "nama" => "Computer System", "kode" => "CS-TEL", "deskripsi" => "-", "kk_id" => "51234567-8901-4122-b123-c12345678902"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600092", "nama" => "Embedded System", "kode" => "ES", "deskripsi" => "-", "kk_id" => "51234567-8901-4122-b123-c12345678902"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600093", "nama" => "Internet of Things", "kode" => "IOT", "deskripsi" => "-", "kk_id" => "51234567-8901-4122-b123-c12345678902"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600094", "nama" => "Artificial Intelligence", "kode" => "AI", "deskripsi" => "-", "kk_id" => "51234567-8901-4122-b123-c12345678902"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600095", "nama" => "Wireless Sensor Network", "kode" => "WSN", "deskripsi" => "-", "kk_id" => "51234567-8901-4122-b123-c12345678902"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600096", "nama" => "Sensor Data Acquisition", "kode" => "SDA", "deskripsi" => "-", "kk_id" => "51234567-8901-4122-b123-c12345678902"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600097", "nama" => "Named Data Networking", "kode" => "NDN", "deskripsi" => "-", "kk_id" => "51234567-8901-4122-b123-c12345678902"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600098", "nama" => "Text Analytics", "kode" => "TXA", "deskripsi" => "-", "kk_id" => "51234567-8901-4122-b123-c12345678902"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600099", "nama" => "Social Media Analytics", "kode" => "SMA-TEL", "deskripsi" => "-", "kk_id" => "51234567-8901-4122-b123-c12345678902"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600100", "nama" => "Networked Dynamical System", "kode" => "NDS", "deskripsi" => "-", "kk_id" => "51234567-8901-4122-b123-c12345678902"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600101", "nama" => "Cyber Physical System", "kode" => "CPS", "deskripsi" => "-", "kk_id" => "51234567-8901-4122-b123-c12345678902"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600102", "nama" => "Cooperative System", "kode" => "COOP", "deskripsi" => "-", "kk_id" => "51234567-8901-4122-b123-c12345678902"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600103", "nama" => "Avionics", "kode" => "AVIO", "deskripsi" => "-", "kk_id" => "51234567-8901-4122-b123-c12345678902"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600104", "nama" => "Security Planning", "kode" => "SECPL", "deskripsi" => "-", "kk_id" => "51234567-8901-4122-b123-c12345678902"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600105", "nama" => "Incident Response and Disaster Recovery", "kode" => "IRDR", "deskripsi" => "-", "kk_id" => "51234567-8901-4122-b123-c12345678902"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600106", "nama" => "Adaptive Infrastructure", "kode" => "ADAPT", "deskripsi" => "-", "kk_id" => "51234567-8901-4122-b123-c12345678902"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600107", "nama" => "Operating System", "kode" => "OS-TEL", "deskripsi" => "-", "kk_id" => "51234567-8901-4122-b123-c12345678902"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600108", "nama" => "Distributed System", "kode" => "DS-TEL", "deskripsi" => "-", "kk_id" => "51234567-8901-4122-b123-c12345678902"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600109", "nama" => "Information-centric Network", "kode" => "ICN", "deskripsi" => "-", "kk_id" => "51234567-8901-4122-b123-c12345678902"],

                /* KK Software Engineering, Information System and Data Engineering */
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600110", "nama" => "Software Engineering", "kode" => "SE-SID", "deskripsi" => "-", "kk_id" => "61234567-8901-4122-b123-c12345678903"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600111", "nama" => "Data Engineering", "kode" => "DE", "deskripsi" => "-", "kk_id" => "61234567-8901-4122-b123-c12345678903"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600112", "nama" => "Information System", "kode" => "IS-SID", "deskripsi" => "-", "kk_id" => "61234567-8901-4122-b123-c12345678903"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600113", "nama" => "Ontology", "kode" => "ONT", "deskripsi" => "-", "kk_id" => "61234567-8901-4122-b123-c12345678903"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600114", "nama" => "Knowledge Based System", "kode" => "KBS", "deskripsi" => "-", "kk_id" => "61234567-8901-4122-b123-c12345678903"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600115", "nama" => "E-Learning", "kode" => "ELRN", "deskripsi" => "-", "kk_id" => "61234567-8901-4122-b123-c12345678903"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600116", "nama" => "Machine Translation", "kode" => "MT", "deskripsi" => "-", "kk_id" => "61234567-8901-4122-b123-c12345678903"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600117", "nama" => "Text mining", "kode" => "TMN-SID", "deskripsi" => "-", "kk_id" => "61234567-8901-4122-b123-c12345678903"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600118", "nama" => "Process-Aware Information Systems", "kode" => "PAIS", "deskripsi" => "-", "kk_id" => "61234567-8901-4122-b123-c12345678903"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600119", "nama" => "Information Architecture", "kode" => "IA", "deskripsi" => "-", "kk_id" => "61234567-8901-4122-b123-c12345678903"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600120", "nama" => "Decision Support System", "kode" => "DSS", "deskripsi" => "-", "kk_id" => "61234567-8901-4122-b123-c12345678903"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600121", "nama" => "Human Computer Interaction", "kode" => "HCI", "deskripsi" => "-", "kk_id" => "61234567-8901-4122-b123-c12345678903"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600122", "nama" => "Software Testing", "kode" => "TEST", "deskripsi" => "-", "kk_id" => "61234567-8901-4122-b123-c12345678903"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600123", "nama" => "Artificial Intelligence (Group)", "kode" => "AI-G", "deskripsi" => "-", "kk_id" => "61234567-8901-4122-b123-c12345678903"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600124", "nama" => "Intelligent Agents", "kode" => "IAG", "deskripsi" => "-", "kk_id" => "61234567-8901-4122-b123-c12345678903"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600125", "nama" => "Image Processing", "kode" => "IMGP", "deskripsi" => "-", "kk_id" => "61234567-8901-4122-b123-c12345678903"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600126", "nama" => "Semantic Big Data", "kode" => "SEMBD", "deskripsi" => "-", "kk_id" => "61234567-8901-4122-b123-c12345678903"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600127", "nama" => "Spatial Database", "kode" => "SPDB", "deskripsi" => "-", "kk_id" => "61234567-8901-4122-b123-c12345678903"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600128", "nama" => "Natural Language Processing (NLP) Group", "kode" => "NLP", "deskripsi" => "-", "kk_id" => "61234567-8901-4122-b123-c12345678903"],

                /* KK Modeling and Computational Experiment */
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600129", "nama" => "Computational Finance", "kode" => "CFIN", "deskripsi" => "-", "kk_id" => "71234567-8901-4122-b123-c12345678904"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600130", "nama" => "Spatial modeling", "kode" => "SPM", "deskripsi" => "-", "kk_id" => "71234567-8901-4122-b123-c12345678904"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600131", "nama" => "Computational Fluid dynamics", "kode" => "CFD", "deskripsi" => "-", "kk_id" => "71234567-8901-4122-b123-c12345678904"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600132", "nama" => "Parallel and Distributed Computing", "kode" => "PDC-MCE", "deskripsi" => "-", "kk_id" => "71234567-8901-4122-b123-c12345678904"],

                /* D. FAKULTAS EKONOMI DAN BISNIS */
                /* KK Strategy, Entrepreneurship and Economics */
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600133", "nama" => "Economics and Policy Study", "kode" => "EPS", "deskripsi" => "-", "kk_id" => "81234567-8901-4122-b123-c12345678905"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600134", "nama" => "Human Capital and Talent Development", "kode" => "HCTD", "deskripsi" => "-", "kk_id" => "81234567-8901-4122-b123-c12345678905"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600135", "nama" => "Start Up and Small Business Development", "kode" => "SSBD", "deskripsi" => "-", "kk_id" => "81234567-8901-4122-b123-c12345678905"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600136", "nama" => "Strategic Management and Decision Making", "kode" => "SMDM", "deskripsi" => "-", "kk_id" => "81234567-8901-4122-b123-c12345678905"],

                /* KK ICT Based Management */
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600137", "nama" => "Marketing (ICT)", "kode" => "MKT-ICT", "deskripsi" => "-", "kk_id" => "91234567-8901-4122-b123-c12345678906"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600138", "nama" => "ICT", "kode" => "ICT", "deskripsi" => "-", "kk_id" => "91234567-8901-4122-b123-c12345678906"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600139", "nama" => "Manajemen Operasional", "kode" => "MO", "deskripsi" => "-", "kk_id" => "91234567-8901-4122-b123-c12345678906"],

                /* KK Finance and Accounting Studies */
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600140", "nama" => "Corporate Finance", "kode" => "CF", "deskripsi" => "-", "kk_id" => "a1234567-8901-4122-b123-c12345678907"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600141", "nama" => "Banking", "kode" => "BNK", "deskripsi" => "-", "kk_id" => "a1234567-8901-4122-b123-c12345678907"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600142", "nama" => "Financial Intermediaries", "kode" => "FI", "deskripsi" => "-", "kk_id" => "a1234567-8901-4122-b123-c12345678907"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600143", "nama" => "Capital Market", "kode" => "CMK", "deskripsi" => "-", "kk_id" => "a1234567-8901-4122-b123-c12345678907"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600144", "nama" => "Akuntansi Keuangan", "kode" => "AKK", "deskripsi" => "-", "kk_id" => "a1234567-8901-4122-b123-c12345678907"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600145", "nama" => "Akuntansi Manajemen", "kode" => "AKM", "deskripsi" => "-", "kk_id" => "a1234567-8901-4122-b123-c12345678907"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600146", "nama" => "Auditing", "kode" => "AUD", "deskripsi" => "-", "kk_id" => "a1234567-8901-4122-b123-c12345678907"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600147", "nama" => "Good Corporate Governance", "kode" => "GCG", "deskripsi" => "-", "kk_id" => "a1234567-8901-4122-b123-c12345678907"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600148", "nama" => "Sistem Informasi Akuntansi", "kode" => "SIA-FEB", "deskripsi" => "-", "kk_id" => "a1234567-8901-4122-b123-c12345678907"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600149", "nama" => "Akuntansi Sektor Publik", "kode" => "ASP-FEB", "deskripsi" => "-", "kk_id" => "a1234567-8901-4122-b123-c12345678907"],

                /* E. FAKULTAS KOMUNIKASI DAN BISNIS */
                /* KK Entrepreneurship (FKB) */
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600150", "nama" => "Business Administration", "kode" => "BA-FKB", "deskripsi" => "-", "kk_id" => "kk-fkb-01"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600151", "nama" => "Marketing (FKB)", "kode" => "MKT-FKB", "deskripsi" => "-", "kk_id" => "kk-fkb-01"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600152", "nama" => "Manajemen", "kode" => "MNJ", "deskripsi" => "-", "kk_id" => "kk-fkb-01"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600153", "nama" => "Ekonomi", "kode" => "EKO", "deskripsi" => "-", "kk_id" => "kk-fkb-01"],

                /* KK Business Policy and Strategy */
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600154", "nama" => "SDM", "kode" => "SDM", "deskripsi" => "-", "kk_id" => "kk-fkb-02"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600155", "nama" => "Keuangan", "kode" => "KEU", "deskripsi" => "-", "kk_id" => "kk-fkb-02"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600156", "nama" => "Marketing (BPS)", "kode" => "MKT-BPS", "deskripsi" => "-", "kk_id" => "kk-fkb-02"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600157", "nama" => "Operation Management", "kode" => "OM", "deskripsi" => "-", "kk_id" => "kk-fkb-02"],

                /* KK Communication Science and Broadcasting */
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600158", "nama" => "Media Literature", "kode" => "ML-FKB", "deskripsi" => "-", "kk_id" => "kk-fkb-03"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600159", "nama" => "Artistic production program", "kode" => "APP", "deskripsi" => "-", "kk_id" => "kk-fkb-03"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600160", "nama" => "Citizen journalism", "kode" => "CJ", "deskripsi" => "-", "kk_id" => "kk-fkb-03"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600161", "nama" => "Media Research", "kode" => "MR", "deskripsi" => "-", "kk_id" => "kk-fkb-03"],

                /* KK Public Relation and Marketing Communication */
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600162", "nama" => "New Media Research", "kode" => "NMR", "deskripsi" => "-", "kk_id" => "kk-fkb-04"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600163", "nama" => "Online Marketing", "kode" => "ONMKT", "deskripsi" => "-", "kk_id" => "kk-fkb-04"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600164", "nama" => "Online Advertising", "kode" => "ONADV", "deskripsi" => "-", "kk_id" => "kk-fkb-04"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600165", "nama" => "Social Media Promotion", "kode" => "SMP", "deskripsi" => "-", "kk_id" => "kk-fkb-04"],

                /* F. FAKULTAS INDUSTRI KREATIF */
                /* KK Art Aesthetic and Practices */
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600166", "nama" => "Pengkajian estetika seni kriya", "kode" => "ESTET-SK", "deskripsi" => "Kearifan lokal nusantara", "kk_id" => "kk-fik-01"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600167", "nama" => "Pengembangan karya seni kriya", "kode" => "KARYA-SK", "deskripsi" => "Inspirasi tradisi nusantara", "kk_id" => "kk-fik-01"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600168", "nama" => "Kompetensi bidang kriya seni", "kode" => "KOMP-SK", "deskripsi" => "Wawasan keilmuan Indonesia", "kk_id" => "kk-fik-01"],

                /* KK Graphis dan Media Kreatif */
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600169", "nama" => "Pengkajian Teori desain", "kode" => "TEO-DSN", "deskripsi" => "Filosofis cultural kearifan lokal", "kk_id" => "kk-fik-02"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600170", "nama" => "Pengembangan objek desain", "kode" => "OBJ-DSN", "deskripsi" => "Inovasi media dan material", "kk_id" => "kk-fik-02"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600171", "nama" => "Pengkajian proses desain", "kode" => "PROS-DSN", "deskripsi" => "Metodologi dan bisnis desain", "kk_id" => "kk-fik-02"],

                /* KK Visual Marketing and Design Management */
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600172", "nama" => "Advertising", "kode" => "ADV-FIK", "deskripsi" => "-", "kk_id" => "kk-fik-03"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600173", "nama" => "Visual Branding", "kode" => "VB", "deskripsi" => "-", "kk_id" => "kk-fik-03"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600174", "nama" => "Design Management", "kode" => "DM-FIK", "deskripsi" => "-", "kk_id" => "kk-fik-03"],

                /* KK Lifestyle and Design Environment */
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600175", "nama" => "Eksplorasi Material", "kode" => "EXMAT", "deskripsi" => "-", "kk_id" => "kk-fik-04"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600176", "nama" => "Desain Produk – IKM", "kode" => "DP-IKM", "deskripsi" => "-", "kk_id" => "kk-fik-04"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600177", "nama" => "Packaging Design", "kode" => "PACK", "deskripsi" => "-", "kk_id" => "kk-fik-04"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600178", "nama" => "Working Tool Design", "kode" => "WTD", "deskripsi" => "-", "kk_id" => "kk-fik-04"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600179", "nama" => "Animasi & Simulasi Digital", "kode" => "ASD", "deskripsi" => "-", "kk_id" => "kk-fik-04"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600180", "nama" => "Digital Prototyping", "kode" => "DPR", "deskripsi" => "-", "kk_id" => "kk-fik-04"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600181", "nama" => "Sustainable Desain", "kode" => "SUST", "deskripsi" => "-", "kk_id" => "kk-fik-04"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600182", "nama" => "Psikologi Persepsi", "kode" => "PSIPER", "deskripsi" => "-", "kk_id" => "kk-fik-04"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600183", "nama" => "Public Places", "kode" => "PP-FIK", "deskripsi" => "-", "kk_id" => "kk-fik-04"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600184", "nama" => "Dwelling", "kode" => "DWL", "deskripsi" => "-", "kk_id" => "kk-fik-04"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600185", "nama" => "Cultural Studies", "kode" => "CLS", "deskripsi" => "-", "kk_id" => "kk-fik-04"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600186", "nama" => "Fisika Bangunan (FIK)", "kode" => "FB-FIK", "deskripsi" => "-", "kk_id" => "kk-fik-04"],

                /* G. FAKULTAS ILMU TERAPAN */
                /* KK Installation, Operation and Maintenance of Telecommunication */
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600187", "nama" => "Perencanaan Jaringan Akses", "kode" => "PJA", "deskripsi" => "Seluler, Optik, Komputer", "kk_id" => "kk-fit-01"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600188", "nama" => "Aplikasi mikrokontroler", "kode" => "AM-FIT", "deskripsi" => "Instrumentasi Berbasis PC/Mobile", "kk_id" => "kk-fit-01"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600189", "nama" => "Aplikasi Pengolahan Sinyal", "kode" => "APS", "deskripsi" => "Citra Digital", "kk_id" => "kk-fit-01"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600190", "nama" => "Optimasi Maintenance", "kode" => "OMT", "deskripsi" => "Sistem Komunikasi", "kk_id" => "kk-fit-01"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600191", "nama" => "Renewable energy (FIT)", "kode" => "RE-FIT", "deskripsi" => "-", "kk_id" => "kk-fit-01"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600192", "nama" => "Sistem Antena (FIT)", "kode" => "ANT-FIT", "deskripsi" => "-", "kk_id" => "kk-fit-01"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600193", "nama" => "Grid Computing", "kode" => "GC", "deskripsi" => "-", "kk_id" => "kk-fit-01"],

                /* KK Interactive System */
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600194", "nama" => "E-Learning System", "kode" => "ELS", "deskripsi" => "Content Development", "kk_id" => "kk-fit-02"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600195", "nama" => "Information System (IS)", "kode" => "IS-FIT", "deskripsi" => "-", "kk_id" => "kk-fit-02"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600196", "nama" => "Game Development", "kode" => "GD", "deskripsi" => "-", "kk_id" => "kk-fit-02"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600197", "nama" => "Virtual Reality (VR)", "kode" => "VR-FIT", "deskripsi" => "-", "kk_id" => "kk-fit-02"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600198", "nama" => "3D Modeling", "kode" => "3DM", "deskripsi" => "-", "kk_id" => "kk-fit-02"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600199", "nama" => "Augmented Reality", "kode" => "AR", "deskripsi" => "-", "kk_id" => "kk-fit-02"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600200", "nama" => "Rich Internet Application", "kode" => "RIA", "deskripsi" => "-", "kk_id" => "kk-fit-02"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600201", "nama" => "Image Processing (FIT)", "kode" => "IP-FIT", "deskripsi" => "-", "kk_id" => "kk-fit-02"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600202", "nama" => "Parallel and Distributed Computing (FIT)", "kode" => "PDC-FIT", "deskripsi" => "-", "kk_id" => "kk-fit-02"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600203", "nama" => "Embedded System (FIT)", "kode" => "ES-FIT", "deskripsi" => "-", "kk_id" => "kk-fit-02"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600204", "nama" => "Internet Of Things (IOT)", "kode" => "IOT-FIT", "deskripsi" => "-", "kk_id" => "kk-fit-02"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600205", "nama" => "Wearable Computing", "kode" => "WC", "deskripsi" => "-", "kk_id" => "kk-fit-02"],

                /* KK IT Governance and Enterprise System */
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600206", "nama" => "Informatika", "kode" => "INF", "deskripsi" => "-", "kk_id" => "kk-fit-03"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600207", "nama" => "Basis Data", "kode" => "BD", "deskripsi" => "-", "kk_id" => "kk-fit-03"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600208", "nama" => "Sistem Informasi (FIT-ITG)", "kode" => "SI-FIT-G", "deskripsi" => "-", "kk_id" => "kk-fit-03"],

                /* KK Sistem Informasi Akuntansi */
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600209", "nama" => "Sistem Informasi Akuntansi", "kode" => "SIA-FIT", "deskripsi" => "-", "kk_id" => "kk-fit-04"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600210", "nama" => "Database (Big Data)", "kode" => "DB-BD", "deskripsi" => "-", "kk_id" => "kk-fit-04"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600211", "nama" => "Data Science", "kode" => "DS-FIT", "deskripsi" => "-", "kk_id" => "kk-fit-04"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600212", "nama" => "Enterprise Resource System", "kode" => "ERS", "deskripsi" => "-", "kk_id" => "kk-fit-04"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600213", "nama" => "Manajemen Keuangan", "kode" => "MK", "deskripsi" => "-", "kk_id" => "kk-fit-04"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600214", "nama" => "Supply Chain Management", "kode" => "SCM", "deskripsi" => "-", "kk_id" => "kk-fit-04"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600215", "nama" => "Pajak", "kode" => "PAJAK", "deskripsi" => "-", "kk_id" => "kk-fit-04"],

                /* KK Programming and Interactive Multimedia */
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600216", "nama" => "Computer Network & Security", "kode" => "CNS", "deskripsi" => "-", "kk_id" => "kk-fit-05"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600217", "nama" => "Protocol Engineering", "kode" => "PE", "deskripsi" => "-", "kk_id" => "kk-fit-05"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600218", "nama" => "Computer System (FIT-P)", "kode" => "CS-FIT-P", "deskripsi" => "-", "kk_id" => "kk-fit-05"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600219", "nama" => "Parallel Processing", "kode" => "PP-FIT", "deskripsi" => "-", "kk_id" => "kk-fit-05"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600220", "nama" => "Neural Network", "kode" => "NN", "deskripsi" => "-", "kk_id" => "kk-fit-05"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600221", "nama" => "Adaptive Learning", "kode" => "AL", "deskripsi" => "-", "kk_id" => "kk-fit-05"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600222", "nama" => "Computer Assisted Learning", "kode" => "CAL", "deskripsi" => "-", "kk_id" => "kk-fit-05"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600223", "nama" => "Network Forensic Analysis", "kode" => "NFA", "deskripsi" => "-", "kk_id" => "kk-fit-05"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600224", "nama" => "Next Generation Firewall", "kode" => "NGF", "deskripsi" => "-", "kk_id" => "kk-fit-05"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600225", "nama" => "Programming (FIT)", "kode" => "PROG-FIT", "deskripsi" => "-", "kk_id" => "kk-fit-05"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600226", "nama" => "Machine Learning (FIT-P)", "kode" => "ML-FIT-P", "deskripsi" => "-", "kk_id" => "kk-fit-05"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600227", "nama" => "Text Mining", "kode" => "TMN-FIT", "deskripsi" => "-", "kk_id" => "kk-fit-05"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600228", "nama" => "Social Network Analysis", "kode" => "SNA", "deskripsi" => "-", "kk_id" => "kk-fit-05"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600229", "nama" => "Ubicomp", "kode" => "UBI", "deskripsi" => "-", "kk_id" => "kk-fit-05"],

                /* KK Commerce Management */
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600230", "nama" => "Marketing Plan", "kode" => "MPL", "deskripsi" => "-", "kk_id" => "kk-fit-06"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600231", "nama" => "Marketing Riset", "kode" => "MRT", "deskripsi" => "-", "kk_id" => "kk-fit-06"],

                /* KK Embedded and Network System */
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600232", "nama" => "Embedded system (FIT-EN)", "kode" => "ES-FIT-EN", "deskripsi" => "-", "kk_id" => "kk-fit-07"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600233", "nama" => "Computer Network (FIT-EN)", "kode" => "CN-FIT-EN", "deskripsi" => "-", "kk_id" => "kk-fit-07"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600234", "nama" => "Network services", "kode" => "NSV", "deskripsi" => "-", "kk_id" => "kk-fit-07"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600235", "nama" => "Network security", "kode" => "NSEC", "deskripsi" => "-", "kk_id" => "kk-fit-07"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600236", "nama" => "Game and Media", "kode" => "GAMED", "deskripsi" => "-", "kk_id" => "kk-fit-07"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600237", "nama" => "Algorithm and programming", "kode" => "ALPROG", "deskripsi" => "-", "kk_id" => "kk-fit-07"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600238", "nama" => "Image processing (FIT-EN)", "kode" => "IP-FIT-EN", "deskripsi" => "-", "kk_id" => "kk-fit-07"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600239", "nama" => "Operating system (FIT-EN)", "kode" => "OS-FIT-EN", "deskripsi" => "-", "kk_id" => "kk-fit-07"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600240", "nama" => "Hardware computer", "kode" => "HWC", "deskripsi" => "-", "kk_id" => "kk-fit-07"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600241", "nama" => "Signal processing (FIT-EN)", "kode" => "SP-FIT-EN", "deskripsi" => "-", "kk_id" => "kk-fit-07"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600242", "nama" => "WSN", "kode" => "WSN-FIT", "deskripsi" => "-", "kk_id" => "kk-fit-07"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600243", "nama" => "Pembangunan jaringan komputer", "kode" => "PJK", "deskripsi" => "-", "kk_id" => "kk-fit-07"],
                ["id" => "4d14b60b-8d5b-4e12-876a-5c1d63600244", "nama" => "Pembangunan sistem komputer", "kode" => "PSK", "deskripsi" => "-", "kk_id" => "kk-fit-07"]
            ];
        foreach ($data as $item) {
            // dd($item);
            RefSubKelompokKeahlian::create($item);
        }
    }
}
