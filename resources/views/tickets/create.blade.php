@extends('layout.template')
@section('styles')
<style>
    * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: Arial, sans-serif;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    background-color: white;
    border-bottom: 1px solid #ddd;
}
ul {
    list-style: none;
    margin-bottom: 20px;
    padding-top: 20px;
}

.logo {
    font-size: 24px;
    font-weight: bold;
}

.menu ul {
    list-style: none;
    display: flex;
    gap: 20px;
}

.menu a {
    text-decoration: none;
    color: #333;
    font-weight: 500;
}

.menu a:hover {
    color: #007BFF;
}

.icons {
    display: flex;
    gap: 15px;
}

.icon {
    text-decoration: none;
    font-size: 20px;
    color: #333;
}

.icon:hover {
    color: #007BFF;
}

/* Responsif */
@media (max-width: 768px) {
    .header {
        flex-direction: column;
        align-items: flex-start;
    }

    .menu ul {
        flex-direction: column;
        gap: 10px;
    }
}

/* Reset default margin and padding */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}



/* Container styling */
.container {
    max-width: 800px; /* Maksimal lebar kontainer */
    margin: 0 auto; /* Pusatkan kontainer */
    padding: 20px; /* Padding di dalam kontainer */
}

/* Heading styling */
h1 {
    font-size: 2.5rem; /* Ukuran font judul */
    color: #2c3e50; /* Warna judul */
    margin-bottom: 20px; /* Jarak bawah judul */
}

/* Form styling */
form {
    background-color: #ffffff; /* Latar belakang formulir */
    border-radius: 8px; /* Sudut melengkung */
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Bayangan */
    padding: 30px; /* Padding di dalam formulir */
}

/* Label styling */
label {
    font-weight: bold; /* Tebal untuk label */
    color: #4a4a4a; /* Warna label */
}

/* Input dan textarea styling */
input[type="text"],
textarea {
    width: 100%; /* Lebar penuh */
    padding: 10px; /* Padding di dalam input */
    border: 1px solid #d1d5db; /* Border abu-abu */
    border-radius: 4px; /* Sudut melengkung */
    transition: border-color 0.3s; /* Transisi border */
}

/* Fokus pada input dan textarea */
input[type="text"]:focus,
textarea:focus {
    border-color: #007bff; /* Warna border saat fokus */
    outline: none; /* Hilangkan outline default */
}

/* Tombol styling */
button {
    width: 100%; /* Lebar penuh */
    padding: 12px; /* Padding di dalam tombol */
    background-color: #007bff; /* Warna latar belakang tombol */
    color: white; /* Warna teks tombol */
    border: none; /* Hilangkan border default */
    border-radius: 4px; /* Sudut melengkung */
    cursor: pointer; /* Kursor pointer saat hover */
    transition: background-color 0.3s, transform 0.2s; /* Transisi untuk hover */
}

/* Efek hover pada tombol */
button:hover {
    background-color: #0056b3; /* Warna latar belakang saat hover */
    transform: scale(1.05); /* Efek zoom saat hover */
}

    </style>

@section('content')
<div class="container mx-auto py-6">
    <h1 class="text-3xl font-bold text-center mb-8 text-gray-800">Buat Tiket Baru</h1>

    <form action="{{ route('tickets.store') }}" method="POST" class="max-w-lg mx-auto bg-white shadow-lg rounded-lg p-6 space-y-6">
        @csrf

        <div>
            <label for="title" class="block font-medium text-gray-700">Judul</label>
            <input type="text" name="title" id="title" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 p-2" required>
        </div>

        <div>
            <label for="message" class="block font-medium text-gray-700">Pesan Pertama (Opsional)</label>
            <textarea name="message" id="message" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 p-2" placeholder="Masukkan pesan pertama Anda"></textarea>
        </div>

        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200 ease-in-out transform hover:scale-105">
            Buat Tiket
        </button>
    </form>
</div>
@endsection
