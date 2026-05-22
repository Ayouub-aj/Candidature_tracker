@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Mes Candidatures</h1>
    <a href="{{ route('candidatures.create') }}" 
       class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        + Nouvelle Candidature
    </a>
</div>

@forelse($candidatures as $candidature)
    <div class="bg-white rounded shadow p-4 mb-4">
        <div class="flex justify-between items-start">
            
            <div>
                <h2 class="text-lg font-bold text-gray-800">{{ $candidature->company }}</h2>
                <p class="text-gray-600">{{ $candidature->position }}</p>
                <p class="text-sm text-gray-500 mt-1">
                    Postulé le : {{ $candidature->applied_at }}
                </p>
                <p class="text-sm mt-1">
                    Entretiens : <span class="font-bold">{{ $candidature->entretiens_count }}</span>
                </p>
            </div>

            <div class="text-right">
                {{-- Status Badge --}}
                <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mb-1">
                    {{ $candidature->status_label }}
                </span>
                <br>
                {{-- Priority Badge --}}
                <span class="inline-block bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded mb-3">
                    {{ $candidature->priority_label }}
                </span>
                <br>
                {{-- Actions --}}
                <a href="{{ route('candidatures.show', $candidature) }}" 
                   class="text-blue-500 hover:underline text-sm mr-2">
                    Voir
                </a>
                <a href="{{ route('candidatures.edit', $candidature) }}" 
                   class="text-green-500 hover:underline text-sm mr-2">
                    Modifier
                </a>
                <form method="POST" 
                      action="{{ route('candidatures.destroy', $candidature) }}" 
                      class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="text-red-500 hover:underline text-sm"
                            onclick="return confirm('Archiver cette candidature ?')">
                        Archiver
                    </button>
                </form>
            </div>

        </div>
    </div>
@empty
    <div class="bg-white rounded shadow p-8 text-center text-gray-500">
        Aucune candidature active. 
        <a href="{{ route('candidatures.create') }}" class="text-blue-500 hover:underline">
            Créez votre première candidature !
        </a>
    </div>
@endforelse

{{-- Archives Link --}}
<div class="mt-6 text-center">
    <a href="{{ route('candidatures.archives') }}" 
       class="text-gray-500 hover:text-gray-700 text-sm underline">
        Voir les candidatures archivées
    </a>
</div>
@endsection