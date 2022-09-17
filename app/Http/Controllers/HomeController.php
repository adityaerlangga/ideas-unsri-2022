<?php

namespace App\Http\Controllers;

use SheetDB\SheetDB;
use Illuminate\Http\Request;
use App\Models\CompetitionUsers;

class HomeController extends Controller
{
    //

    public function __construct()
    {
        $this->dataLomba = [
            "bem-fe" => [
                "nama" => "BEM Fakultas Ekonomi",
                "lomba" => [
                    [
                        "id" => 1,
                        "nama" => "International Economic Poster Competition (IEP)"
                    ],
                    [
                        "id" => 2,
                        "nama" => "After Movie"
                    ],
                    [
                        "id" => 3,
                        "nama" => "Policy Case Competition (PCC)"
                    ],
                    [
                        "id" => 4,
                        "nama" => "Contest Economic Quiz"
                    ],
                ]
            ],
            "ima" => [
                "nama" => "Ikatan Mahasiswa Akuntasi",
                "lomba" => [
                    [
                        "id" => 5,
                        "nama" => "Sriwijaya Accounting Olympiad (SAO)"
                    ],
                    [
                        "id" => 6,
                        "nama" => "Paper Writing Conference (PWC)"
                    ],
                    [
                        "id" => 7,
                        "nama" => "Sriwijaya Debate Competition (SDC)"
                    ],
                    [
                        "id" => 8,
                        "nama" => "Acoustic Competition (ACTION)"
                    ],
                ]
            ],
            "imaje" => [
                "nama" => "Ikatan Mahasiswa Manajemen",
                "lomba" => [
                    [
                        "id" => 9,
                        "nama" => "Business Case Competition"
                    ],
                    [
                        "id" => 10,
                        "nama" => "Paper Competition"
                    ],
                    [
                        "id" => 11,
                        "nama" => "Lomba Paduan Suara"
                    ],
                ]
            ],
            "imepa" => [
                "nama" => "Ikatan Mahasiswa Ekonomi Pembangunan",
                "lomba" => [
                    [
                        "id" => 12,
                        "nama" => "Olimpiade Economic Development Fair 4.0 (EDNATION)"
                    ],
                    [
                        "id" => 13,
                        "nama" => "Lomba Karya Tulis Ilmiah (LKTI) Economic Development Fair 4.0 (EDNATION)"
                    ],
                    [
                        "id" => 14,
                        "nama" => "Lomba Infografis Ed Fair 4.0 (EDSPORTION)"
                    ],
                    [
                        "id" => 15,
                        "nama" => "Tari Kreasi Ed Fair 4.0 (EDSPORTION)"
                    ],
                ]
            ],
        ];
    }

    public function Index()
    {
        return view("home");
    }

    public function Organisasi($organisasi = "bem-fe")
    {
        $daftar_organisasi = ["bem-fe", "ima", "imaje", "imepa"];
        if (!in_array($organisasi, $daftar_organisasi)) {
            return redirect()->to(url("/"));
        }



        $data = $this->dataLomba[$organisasi];
        // dd($data["nama"]);
        return view("organisasi", $data);
    }

    public function Competition($jenis = 1)
    {
        if ($jenis < 1 || $jenis > 15) {
            return redirect()->to(url('/'));
        }

        $lomba = [
            1 => ["organisasi" => "BEM Fakultas Ekonomi", "nama" => "International Economic Poster Competition (IEP)"],
            2 => ["organisasi" => "BEM Fakultas Ekonomi", "nama" => "After Movie"],
            3 => ["organisasi" => "BEM Fakultas Ekonomi", "nama" => "Policy Case Competition (PCC)"],
            4 => ["organisasi" => "BEM Fakultas Ekonomi", "nama" => "Contest Economic Quiz"],
            5 => ["organisasi" => "Ikatan Mahasiswa Akuntansi", "nama" => "Sriwijaya Accounting Olympiad (SAO)"],
            6 => ["organisasi" => "Ikatan Mahasiswa Akuntansi", "nama" => "Paper Writing Conference (PWC)"],
            7 => ["organisasi" => "Ikatan Mahasiswa Akuntansi", "nama" => "Sriwijaya Debate Competition (SDC)"],
            8 => ["organisasi" => "Ikatan Mahasiswa Akuntansi", "nama" => "Acoustic Competition (ACTION)"],
            9 => ["organisasi" => "Ikatan Mahasiswa Manajemen", "nama" => "Business Case Competition"],
            10 => ["organisasi" => "Ikatan Mahasiswa Manajemen", "nama" => "Paper Competition"],
            11 => ["organisasi" => "Ikatan Mahasiswa Manajemen", "nama" => "Lomba Panduan Suara"],
            12 => ["organisasi" => "Ikatan Mahasiswa Ekonomi Pembangunan", "nama" => "Olimpiade Economic Development Fair 4.0 (EDNATION)"],
            13 => ["organisasi" => "Ikatan Mahasiswa Ekonomi Pembangunan", "nama" => "Lomba Karya Tulis Ilmiah (LKTI) Economic Development Fair 4.0 (EDNATION)"],
            14 => ["organisasi" => "Ikatan Mahasiswa Ekonomi Pembangunan", "nama" => "Lomba Infografis Ed Fair 4.0 (EDSPORTION)"],
            15 => ["organisasi" => "Ikatan Mahasiswa Ekonomi Pembangunan", "nama" => "Tari Kreasi Ed Fair 4.0 (EDSPORTION)"],
        ];
        $data = $lomba[$jenis];
        // dd($data);

        return view("register", $data);
    }

    public function Store(Request $request)
    {
        $jenis = ['Business Case' => 1, 'Video Promotion' => 2];
        $validatedData = $request->validate([
            'competition' => 'required|max:255',
            'team_name' => 'required|max:255',
            'university' => 'required|max:255',
            'ktm' => 'required|mimetypes:application/pdf|max:10240',
            'leader_name' => 'required|max:255',
            'leader_number' => 'required|max:255',
            'leader_major' => 'required|max:255',
            'leader_email' => 'required|max:255',
            'leader_birth_date' => 'required|max:255',
            'member1_name' => 'required|max:255',
            'member1_number' => 'required|max:255',
            'member1_major' => 'required|max:255',
            'member1_email' => 'required|max:255',
            'member2_name' => 'max:255',
            'member2_number' => 'max:255',
            'member2_major' => 'max:255',
            'member2_email' => 'max:255',
        ]);

        // PDF
        $PDFName = time() . "." . $request->file("ktm")->extension();
        $PDFDirectory = $request->file("ktm")->move(public_path("assets/ktm"), $PDFName);
        $validatedData['ktm'] = $PDFName;

        // Create and get ID
        $id = CompetitionUsers::create($validatedData)->id;
        // SpreadSheet
        $Competition = $request->get('competition');
        $TeamName = $request->get('team_name');
        $University = $request->get('university');
        $KTM = asset('assets/ktm/' . $PDFName);
        $LeaderName = $request->get('leader_name');
        $LeaderNumber = $request->get('leader_number');
        $LeaderMajor = $request->get('leader_major');
        $LeaderEmail = $request->get('leader_email');
        $LeaderBirthDate = $request->get('leader_birth_date');
        $Member1Name = $request->get('member1_name');
        $Member1Number = $request->get('member1_number');
        $Member1Major = $request->get('member1_major');
        $Member1Email = $request->get('member1_email');
        $Member2Name = $request->get('member2_name');
        $Member2Number = $request->get('member2_number');
        $Member2Major = $request->get('member2_major');
        $Member2Email = $request->get('member2_email');

        $dataSpreadsheet = [
            'ID' => $id,
            'Competition' => $Competition,
            'TeamName' => $TeamName,
            'University' => $University,
            'KTM' => $KTM,
            'LeaderName' => $LeaderName,
            'LeaderNumber' => $LeaderNumber,
            'LeaderMajor' => $LeaderMajor,
            'LeaderEmail' => $LeaderEmail,
            'LeaderBirthDate' => $LeaderBirthDate,
            'Member1Name' => $Member1Name,
            'Member1Number' => $Member1Number,
            'Member1Major' => $Member1Major,
            'Member1Email' => $Member1Email,
            'Member2Name' => $Member2Name,
            'Member2Number' => $Member2Number,
            'Member2Major' => $Member2Major,
            'Member2Email' => $Member2Email,
        ];

        $sheetdb = new SheetDB('ow442rsvfr4tz');
        $sheetdb->create($dataSpreadsheet);

        return redirect()->to(url('/register/' . $jenis[$request->get('competition')]))->with('success', 'Terima kasih, tim: ' . $request->get('team_name') . ' telah berhasil didaftarkan! Silahkan tunggu informasi selanjutnya');
    }

    public function getSheet()
    {
        $sheetdb = new SheetDB('ow442rsvfr4tz');
        dd($sheetdb->get());
    }
}