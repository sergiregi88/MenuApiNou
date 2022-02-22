
@extends('layouts.master')
@section('title', 'Error Detected')
 @section('meta_tags')

@section('header')
    <h2>Error on App<h2 >
@endsection

@section('content')
    <h1>Error Description</h1>
    {{ $message }}
@endsection​

