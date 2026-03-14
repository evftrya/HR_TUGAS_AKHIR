@include('layouts.navigation')

<x-guest-layout>
<div class="flex items-center justify-center min-h-screen px-4">

    <div class="bg-white shadow-lg rounded-2xl p-6 sm:p-8 w-full max-w-md text-center">

        <h2 class="text-xl sm:text-2xl font-bold mb-2">
            Verifikasi Email
        </h2>

        <p class="text-gray-500 text-sm sm:text-base mb-6">
            Masukkan kode verifikasi yang telah dikirim ke email kamu.
        </p>

        <form id="otpForm" action="{{ route('verify-email.send') }}" method="POST">
            @csrf

            <div class="flex justify-center gap-2 sm:gap-3 mb-4">

                <input type="text" maxlength="1" inputmode="numeric" class="otp w-10 h-10 sm:w-12 sm:h-12 text-center border rounded-lg">
                <input type="text" maxlength="1" inputmode="numeric" class="otp w-10 h-10 sm:w-12 sm:h-12 text-center border rounded-lg">
                <input type="text" maxlength="1" inputmode="numeric" class="otp w-10 h-10 sm:w-12 sm:h-12 text-center border rounded-lg">
                <input type="text" maxlength="1" inputmode="numeric" class="otp w-10 h-10 sm:w-12 sm:h-12 text-center border rounded-lg">
                <input type="text" maxlength="1" inputmode="numeric" class="otp w-10 h-10 sm:w-12 sm:h-12 text-center border rounded-lg">
                <input type="text" maxlength="1" inputmode="numeric" class="otp w-10 h-10 sm:w-12 sm:h-12 text-center border rounded-lg">

            </div>

            <!-- hidden gabungan OTP -->
            <input type="hidden" name="otp" id="otpFull">
            <input type="hidden" name="email_institusi" value="{{ old('email_institusi') ?? request()->input('email_institusi') }}">

            <div class="text-xs text-gray-500 mb-6 space-y-1">
                <p>
                    Tekan <span class="font-semibold bg-gray-100 px-2 py-1 rounded">Q</span>
                    untuk reset kode
                </p>

                <p>
                    Tekan <span class="font-semibold bg-gray-100 px-2 py-1 rounded">F2</span>
                    untuk kirim verifikasi
                </p>
            </div>

            <button type="submit"
            class="w-full bg-blue-600 text-white py-2 sm:py-3 rounded-lg hover:bg-blue-700 transition">
                Verifikasi
            </button>

        </form>

    </div>

</div>


<script>

const inputs = document.querySelectorAll(".otp");
const form = document.getElementById("otpForm");
const otpFull = document.getElementById("otpFull");


// AUTO PINDAH INPUT
inputs.forEach((input, index) => {

    input.addEventListener("input", (e) => {

        e.target.value = e.target.value.replace(/[^0-9]/g, "");

        if (e.target.value && index < inputs.length - 1) {
            inputs[index + 1].focus();
        }

    });

    input.addEventListener("keydown", (e) => {

        if (e.key === "Backspace" && input.value === "" && index > 0) {
            inputs[index - 1].focus();
        }

    });

});


// PASTE OTP
inputs[0].addEventListener("paste", function(e) {

    let pasteData = e.clipboardData.getData("text").replace(/[^0-9]/g, "");

    if(pasteData.length === inputs.length){

        inputs.forEach((input, i) => {
            input.value = pasteData[i];
        });

    }

    e.preventDefault();

});


// GABUNGKAN OTP SEBELUM SUBMIT
form.addEventListener("submit", function(){

    let otp = "";

    inputs.forEach(input => {
        otp += input.value;
    });

    otpFull.value = otp;

});


// SHORTCUT
document.addEventListener("keydown", function(e) {

    if (e.key.toLowerCase() === "q") {

        inputs.forEach(input => input.value = "");
        inputs[0].focus();

        // alert("Kode OTP direset.");

    }

    if (e.key === "F2") {

        e.preventDefault();
        form.submit();

    }

});

</script>

</x-guest-layout>