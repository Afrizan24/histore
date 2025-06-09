@extends('layouts.app')

@section('title', 'Store Information - Kiansantang Store')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold mb-6 text-center">Store Information</h1>

    <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
        <h2 class="text-2xl font-semibold mb-4">Contact Us</h2>
        <p class="text-gray-700 mb-2"><i class="fas fa-map-marker-alt mr-2"></i> <strong>Location:</strong> Jl. Contoh No. 123, Kota Contoh, Provinsi Contoh</p>
        <p class="text-gray-700 mb-2"><i class="fas fa-phone mr-2"></i> <strong>Phone:</strong> (021) 123-4567</p>
        <p class="text-gray-700 mb-2"><i class="fas fa-envelope mr-2"></i> <strong>Email:</strong> info@kiansantangstore.com</p>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
        <h2 class="text-2xl font-semibold mb-4">Opening Hours</h2>
        <ul class="list-disc list-inside text-gray-700">
            <li>Monday - Friday: 09:00 AM - 08:00 PM</li>
            <li>Saturday: 10:00 AM - 06:00 PM</li>
            <li>Sunday: Closed</li>
        </ul>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-semibold mb-4">Other Information</h2>
        <p class="text-gray-700 mb-2">We offer a wide range of original Apple products and accessories with competitive prices and excellent customer service. Our dedicated sales team is ready to assist you with all your needs.</p>
        <p class="text-gray-700">For more details, feel free to visit our store or contact us via phone/email during opening hours.</p>
    </div>
</div>
@endsection 