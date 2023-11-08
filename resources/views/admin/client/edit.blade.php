@extends('layouts.app')
@section('content')
<div class="content">
    <div class="intro-y col-span-12 lg:col-span-6">
        <!-- BEGIN: Vertical Form -->
        <div class="intro-y box">
            <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
                <h2 class="font-medium text-base mr-auto">
                    Edit Client
                </h2>
                <div class="w-full sm:w-auto flex items-center sm:ml-auto mt-3 sm:mt-0">
                </div>
            </div>
            <form action="{{route('client.update', $client)}}" method="POST">
                @csrf
                @method('PUT')
            <div class="p-5" id="vertical-form">
                <div class="preview">
                    <div>
                        <label>Nama Client</label>
                        <input type="text" name="name" class="input w-full border mt-2" placeholder="Nama Client" value="{{ $client->name }}">
                    </div>
                    <div class="mt-3">
                        <label>Sumber</label>
                        <select name="sumber" class="input w-full border mt-2">
                            <option value="TEMAN" {{ $client->sumber == 'TEMAN' ? 'selected' : '' }}>Teman</option>
                            <option value="IKLAN" {{ $client->sumber == 'IKLAN' ? 'selected' : '' }}>Iklan</option>
                            <option value="WA" {{ $client->sumber == 'WA' ? 'selected' : '' }}>Whatsapp</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label>Nomor Whatsapp</label>
                        <input type="number" name="wa" class="input w-full border mt-2" value="{{ $client->wa }}">
                    </div>
                    <div class="mt-3">
                        <label>Email</label>
                        <input type="email" name="email" class="input w-full border mt-2" placeholder="example@gmail.com" value="{{ $client->email }}">
                    </div>
                    <div class="mt-3">
                        <label>Alamat</label>
                        <input type="text" name="alamat" class="input w-full border mt-2" placeholder="Alamat" value="{{ $client->alamat }}">
                    </div>
                    <button type="submit" class="button bg-theme-1 text-white mt-5">Submit</button>
                </div>
                <div class="source-code hidden">
                    <button data-target="#copy-vertical-form" class="copy-code button button--sm border flex items-center text-gray-700"> <i data-feather="file" class="w-4 h-4 mr-2"></i> Copy code </button>
                    <div class="overflow-y-auto h-64 mt-3">
                        <pre class="source-preview" id="copy-vertical-form"> <code class="text-xs p-0 rounded-md html pl-5 pt-8 pb-4 -mb-10 -mt-10"> HTMLOpenTagdivHTMLCloseTag HTMLOpenTaglabelHTMLCloseTagEmailHTMLOpenTag/labelHTMLCloseTag HTMLOpenTaginput type=&quot;email&quot; class=&quot;input w-full border mt-2&quot; placeholder=&quot;example@gmail.com&quot;HTMLCloseTag HTMLOpenTag/divHTMLCloseTag HTMLOpenTagdiv class=&quot;mt-3&quot;HTMLCloseTag HTMLOpenTaglabelHTMLCloseTagPasswordHTMLOpenTag/labelHTMLCloseTag HTMLOpenTaginput type=&quot;password&quot; class=&quot;input w-full border mt-2&quot; placeholder=&quot;secret&quot;HTMLCloseTag HTMLOpenTag/divHTMLCloseTag HTMLOpenTagdiv class=&quot;flex items-center text-gray-700 mt-5&quot;HTMLCloseTag HTMLOpenTaginput type=&quot;checkbox&quot; class=&quot;input border mr-2&quot; id=&quot;vertical-remember-me&quot;HTMLCloseTag HTMLOpenTaglabel class=&quot;cursor-pointer select-none&quot; for=&quot;vertical-remember-me&quot;HTMLCloseTagRemember meHTMLOpenTag/labelHTMLCloseTag HTMLOpenTag/divHTMLCloseTag HTMLOpenTagbutton type=&quot;button&quot; class=&quot;button bg-theme-1 text-white mt-5&quot;HTMLCloseTagLoginHTMLOpenTag/buttonHTMLCloseTag </code> </pre>
                    </div>
                </div>
            </div>
        </div>
    </form>
        <!-- END: Vertical Form -->
</div>
@endsection