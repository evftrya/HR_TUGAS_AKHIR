<?php

namespace Database\Seeders;

use App\Models\RefKelompokKeahlian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RefKelompokKeahlianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data =
            [

                [
                    "id" => "672957e1-8557-4f6c-8515-b777a1122a01",
                    "nama" => "KK Transmisi Telekomunikasi",
                    "kode" => "TT",
                    "deskripsi" => "-",
                    "fakultas_id" => "8b8ead85-5ff9-4308-b70d-607f9570a492"
                ],
                [
                    "id" => "f58f793b-967a-4934-9276-805175936496",
                    "nama" => "KK Jaringan Multimedia",
                    "kode" => "JM",
                    "deskripsi" => "-",
                    "fakultas_id" => "8b8ead85-5ff9-4308-b70d-607f9570a492"
                ],
                [
                    "id" => "04c10557-0744-460d-8549-36879815049b",
                    "nama" => "KK Rekayasa Komputer",
                    "kode" => "RK",
                    "deskripsi" => "-",
                    "fakultas_id" => "8b8ead85-5ff9-4308-b70d-607f9570a492"
                ],
                [
                    "id" => "b309605d-2b47-4144-8025-067823528859",
                    "nama" => "KK Pengolahan Sinyal Informasi",
                    "kode" => "PSI",
                    "deskripsi" => "-",
                    "fakultas_id" => "8b8ead85-5ff9-4308-b70d-607f9570a492"
                ],
                [
                    "id" => "8032734a-939b-4e63-8822-632342557765",
                    "nama" => "KK Sistem Elektronika",
                    "kode" => "SE",
                    "deskripsi" => "-",
                    "fakultas_id" => "8b8ead85-5ff9-4308-b70d-607f9570a492"
                ],
                [
                    "id" => "d0408518-8684-4863-8865-884812300091",
                    "nama" => "KK Rekayasa Instrumentasi dan Energi",
                    "kode" => "RIE",
                    "deskripsi" => "-",
                    "fakultas_id" => "8b8ead85-5ff9-4308-b70d-607f9570a492"
                ],

                /* B. FAKULTAS REKAYASA INDUSTRI (ID=> 2eb0b147-3553-4ac5-83c5-6750b004c8b9) */
                [
                    "id" => "67324831-5079-4301-8314-112347596012",
                    "nama" => "KK e-Process and Work System Optimization",
                    "kode" => "PWSO",
                    "deskripsi" => "-",
                    "fakultas_id" => "2eb0b147-3553-4ac5-83c5-6750b004c8b9"
                ],
                [
                    "id" => "31248067-1011-4467-9122-340679812456",
                    "nama" => "KK e-Engineering Management",
                    "kode" => "EM",
                    "deskripsi" => "-",
                    "fakultas_id" => "2eb0b147-3553-4ac5-83c5-6750b004c8b9"
                ],
                [
                    "id" => "55091244-8891-4122-9901-561239845712",
                    "nama" => "KK e-System Development",
                    "kode" => "ESD",
                    "deskripsi" => "-",
                    "fakultas_id" => "2eb0b147-3553-4ac5-83c5-6750b004c8b9"
                ],
                [
                    "id" => "99102345-6678-4122-8812-771239456789",
                    "nama" => "KK e-Solution and Assurance",
                    "kode" => "ESA",
                    "deskripsi" => "-",
                    "fakultas_id" => "2eb0b147-3553-4ac5-83c5-6750b004c8b9"
                ],

                /* C. FAKULTAS INFORMATIKA (ID=> 426d4553-31a7-4b3f-8965-4e39b1750eb0) */
                [
                    "id" => "41234567-8901-4122-b123-c12345678901",
                    "nama" => "KK Intelligent, Computing and Multimedia",
                    "kode" => "ICM",
                    "deskripsi" => "Pengkajian mengenai estetika Informatika mengenai Intellegensia, Computing, dan Multimedia.",
                    "fakultas_id" => "426d4553-31a7-4b3f-8965-4e39b1750eb0"
                ],
                [
                    "id" => "51234567-8901-4122-b123-c12345678902",
                    "nama" => "KK Telematics",
                    "kode" => "TEL",
                    "deskripsi" => "-",
                    "fakultas_id" => "426d4553-31a7-4b3f-8965-4e39b1750eb0"
                ],
                [
                    "id" => "61234567-8901-4122-b123-c12345678903",
                    "nama" => "KK Software Engineering, Information System and Data Engineering",
                    "kode" => "SEISDE",
                    "deskripsi" => "-",
                    "fakultas_id" => "426d4553-31a7-4b3f-8965-4e39b1750eb0"
                ],
                [
                    "id" => "71234567-8901-4122-b123-c12345678904",
                    "nama" => "KK Modeling and Computational Experiment",
                    "kode" => "MCE",
                    "deskripsi" => "-",
                    "fakultas_id" => "426d4553-31a7-4b3f-8965-4e39b1750eb0"
                ],

                /* D. FAKULTAS EKONOMI DAN BISNIS (ID=> 5852287b-2284-43cf-9fef-bc2742e68d93) */
                [
                    "id" => "81234567-8901-4122-b123-c12345678905",
                    "nama" => "KK Strategy, Entrepreneurship and Economics",
                    "kode" => "SEE",
                    "deskripsi" => "-",
                    "fakultas_id" => "5852287b-2284-43cf-9fef-bc2742e68d93"
                ],
                [
                    "id" => "91234567-8901-4122-b123-c12345678906",
                    "nama" => "KK ICT Based Management",
                    "kode" => "IBM",
                    "deskripsi" => "-",
                    "fakultas_id" => "5852287b-2284-43cf-9fef-bc2742e68d93"
                ],
                [
                    "id" => "a1234567-8901-4122-b123-c12345678907",
                    "nama" => "KK Finance and Accounting Studies",
                    "kode" => "FAS",
                    "deskripsi" => "-",
                    "fakultas_id" => "5852287b-2284-43cf-9fef-bc2742e68d93"
                ],

                /* E. FAKULTAS KOMUNIKASI DAN BISNIS (ID=> e4414f52-706d-4682-95f7-876e4695015e) */
                [
                    "id" => "kk-fkb-01",
                    "nama" => "KK Entrepreneurship",
                    "kode" => "ENT",
                    "deskripsi" => "-",
                    "fakultas_id" => "e4414f52-706d-4682-95f7-876e4695015e"
                ],
                [
                    "id" => "kk-fkb-02",
                    "nama" => "KK Business Policy and Strategy",
                    "kode" => "BPS",
                    "deskripsi" => "-",
                    "fakultas_id" => "e4414f52-706d-4682-95f7-876e4695015e"
                ],
                [
                    "id" => "kk-fkb-03",
                    "nama" => "KK Communication Science and Broadcasting",
                    "kode" => "CSB",
                    "deskripsi" => "-",
                    "fakultas_id" => "e4414f52-706d-4682-95f7-876e4695015e"
                ],
                [
                    "id" => "kk-fkb-04",
                    "nama" => "KK Public Relation and Marketing Communication",
                    "kode" => "PRMC",
                    "deskripsi" => "-",
                    "fakultas_id" => "e4414f52-706d-4682-95f7-876e4695015e"
                ],

                /* F. FAKULTAS INDUSTRI KREATIF (ID=> 7649d63b-6e71-4171-884c-352019777174) */
                [
                    "id" => "kk-fik-01",
                    "nama" => "KK Art Aesthetic and Practices",
                    "kode" => "AAP",
                    "deskripsi" => "Pengkajian estetika seni, kriya dan tradisi nusantara.",
                    "fakultas_id" => "7649d63b-6e71-4171-884c-352019777174"
                ],
                [
                    "id" => "kk-fik-02",
                    "nama" => "KK Graphis dan Media Kreatif",
                    "kode" => "GMK",
                    "deskripsi" => "Pengkajian Teori desain berbasis kearifan lokal.",
                    "fakultas_id" => "7649d63b-6e71-4171-884c-352019777174"
                ],
                [
                    "id" => "kk-fik-03",
                    "nama" => "KK Visual Marketing and Design Management",
                    "kode" => "VMDM",
                    "deskripsi" => "-",
                    "fakultas_id" => "7649d63b-6e71-4171-884c-352019777174"
                ],
                [
                    "id" => "kk-fik-04",
                    "nama" => "KK Lifestyle and Design Environment",
                    "kode" => "LDE",
                    "deskripsi" => "-",
                    "fakultas_id" => "7649d63b-6e71-4171-884c-352019777174"
                ],

                /* G. FAKULTAS ILMU TERAPAN (ID=> 99354067-172c-4740-985f-8255e2be1960) */
                [
                    "id" => "kk-fit-01",
                    "nama" => "KK Installation, Operation and Maintenance of Telecommunication",
                    "kode" => "IOMT",
                    "deskripsi" => "-",
                    "fakultas_id" => "99354067-172c-4740-985f-8255e2be1960"
                ],
                [
                    "id" => "kk-fit-02",
                    "nama" => "KK Interactive System",
                    "kode" => "IS",
                    "deskripsi" => "-",
                    "fakultas_id" => "99354067-172c-4740-985f-8255e2be1960"
                ],
                [
                    "id" => "kk-fit-03",
                    "nama" => "KK IT Governance and Enterprise System",
                    "kode" => "ITGES",
                    "deskripsi" => "-",
                    "fakultas_id" => "99354067-172c-4740-985f-8255e2be1960"
                ],
                [
                    "id" => "kk-fit-04",
                    "nama" => "KK Sistem Informasi Akuntansi",
                    "kode" => "SIA",
                    "deskripsi" => "-",
                    "fakultas_id" => "99354067-172c-4740-985f-8255e2be1960"
                ],
                [
                    "id" => "kk-fit-05",
                    "nama" => "KK Programming and Interactive Multimedia",
                    "kode" => "PIM",
                    "deskripsi" => "-",
                    "fakultas_id" => "99354067-172c-4740-985f-8255e2be1960"
                ],
                [
                    "id" => "kk-fit-06",
                    "nama" => "KK Commerce Management",
                    "kode" => "CM",
                    "deskripsi" => "-",
                    "fakultas_id" => "99354067-172c-4740-985f-8255e2be1960"
                ],
                [
                    "id" => "kk-fit-07",
                    "nama" => "KK Embedded and Network System",
                    "kode" => "ENS",
                    "deskripsi" => "-",
                    "fakultas_id" => "99354067-172c-4740-985f-8255e2be1960"
                ]
            ];

        foreach ($data as $item) {
            // dd($item);
            RefKelompokKeahlian::create($item);
        }
    }
}
