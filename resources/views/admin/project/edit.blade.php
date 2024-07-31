@extends('layouts.app')

@section('content')
    <div class="container py-5 px-5">
        <h1 class="text-center p-3 text-danger bg-dark">Modifica il tuo project</h1>

        @include('shared.errors')
        <form action="{{ route('admin.projects.update', $project) }}" method="Post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3 ">
                <label for="exampleFormControlInput1" class="form-label">Modifica titolo</label>
                <input type="text" class="form-control border border-black" id="project-title" name="title"
                    value="{{ old('title', $project->title) }}">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Modifica descrizione</label>
                <textarea class="form-control border border-black" id="project-description" name="description" rows="3"> {{ old('description', $project->description) }}</textarea>
            </div>
            <div class="d-flex my-3 gap-5">
                <div class="mb-3 col-5">
                    <label for="formFileMultiple" class="form-label">Modifica immagine</label>
                    <input class="form-control" type="file" id="project-image" name="cover_image">
                </div>
                <div class=" margin-t col-2 ms-5">
                    <label for="formFileMultiple" class="form-label">Inserisci una tipologia</label>
                    <select class="form-select" aria-label="Default select example" name="type_id">
                        <option selected disabled value="">Type</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}" @if (old('type_id') == $type->id) selected @endif>
                                {{ $type->title }}</option>
                        @endforeach

                    </select>
                </div>
            </div>
            <div class="d-flex my-4 gap-3">
                <button type="submit" class="btn btn-outline-success ">Modifica progetto</button>
        </form>
        <form action="{{ route('admin.projects.destroy', $project) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger" data-bs-toggle="tooltip" title="Elimina"
                onclick="return confirm('Sei sicuro di voler eliminare questo progetto?')"> Elimina
            </button>
        </form>
    </div>
    </div>
@endsection
