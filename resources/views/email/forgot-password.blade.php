<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Atur Ulang Password</title>
</head>

<body style="margin:0; padding:0; background-color:#f5f5f5; font-family:Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center">

                <table width="500" cellpadding="0" cellspacing="0" border="0"
                    style="background:#ffffff; margin-top:40px; border-radius:8px; overflow:hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">

                    <tr>
                        <td style="padding:40px 30px 20px 30px; text-align:center;">
                            <h2 style="margin:0; color:#333; font-size: 24px;">Permintaan Atur Ulang Password</h2>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:0 40px; text-align:center;">
                            <p style="color:#555; font-size:15px; line-height:1.6; margin:0;">
                                Kami menerima permintaan untuk mengganti password akun Anda. 
                                Klik tombol di bawah ini untuk melanjutkan proses pembuatan password baru.
                            </p>

                            <div style="margin:30px 0;">
                                <a href="{{ route('forget-password.action',['email_institusi' => $email_institusi, 'verified_code'=> $kode_verifikasi]) }}" 
                                   style="
                                    background-color:#c6302c; 
                                    color:#ffffff; 
                                    padding:15px 30px; 
                                    text-decoration:none; 
                                    font-size:16px; 
                                    font-weight:bold; 
                                    border-radius:5px; 
                                    display:inline-block;
                                   ">
                                    Atur Ulang Password
                                </a>
                            </div>

                            <p style="color:#e74c3c; font-size:13px; margin-bottom:20px;">
                                Tautan ini hanya berlaku selama <b>5 menit</b>.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:20px 40px 40px 40px; text-align:center;">
                            <hr style="border:none; border-top:1px solid #eee; margin-bottom:20px;">
                            <p style="color:#999; font-size:12px; line-height:1.5;">
                                <b>Bukan Anda?</b> Jika Anda tidak merasa meminta perubahan password, 
                                abaikan saja email ini. Akun Anda tetap aman dan tidak ada perubahan yang dilakukan.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="background-color:#f9f9f9; padding:20px; text-align:center; font-size:12px; color:#aaaaaa;">
                            © 2026 Sistem Verifikasi SDM Telkom University Surabaya<br>
                            Jl. Ketintang No. 156, Surabaya
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>