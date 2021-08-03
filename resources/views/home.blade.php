<!DOCTYPE html>
@extends('layouts.base')

@section('content')
    <h2>
        Temperature by Cities
    </h2>
    @include('input-form');
    @include('entries-table');
@endsection
