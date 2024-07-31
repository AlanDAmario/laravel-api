<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; //importazione sluge

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        

        // Recupera tutti i tipi per il dropdown
        $types = Type::all();


        // Inizia la query per recuperare i progetti solo per l'utente autenticato
        $query = Project::where('user_id', Auth::user()->id);

        // Recupera i progetti con filtro opzionale per tipo
        //$query = Project::query();

        // Se c'è un parametro 'type_id' nella richiesta, applica il filtro
        if ($request->has('type_id') && $request->type_id) {
            $query->where('type_id', $request->type_id);
        }

        // Recupera i progetti filtrati o tutti se nessun filtro è applicato
        $projects = $query->paginate(10);

        // Passa i progetti e i tipi alla vista
        return view('admin.project.index', compact('projects', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Questo codice recupera tutti i record dalla tabella types e li memorizza nella variabile $types.
        $types = Type::all();
        // Passa i tipi di progetto alla vista attraverso compact ('types'), che li trasforma in array associativi.
        return view('admin.project.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        // Valida i dati della richiesta usando la classe StoreProjectRequest
        $data = $request->validated();

        $current_user= Auth::user()->id;

        // Crea uno slug basato sul titolo fornito
        $data['slug'] = Str::of($data['title'])->slug('-');

        // Gestione dell'immagine di copertura
        if ($request->hasFile('cover_image')) {
            // Se è stata fornita un'immagine, salvala nella cartella 'cover_images' e ottieni il percorso
            $img_path = $request->file('cover_image')->store('cover_images');
        } else {
            // Se non è stata fornita un'immagine, imposta il percorso su NULL
            $img_path = NULL;
        }

        // Crea una nuova istanza del modello Project
        $project = new Project();

        // Assegna il percorso dell'immagine al modello
        $project->cover_image = $img_path;

        // Assegna tutti gli altri dati al modello, escludendo l'immagine che è già stata gestita separatamente
        $project->title = $data['title'];
        $project->description = $data['description'];
        $project->slug = $data['slug'];

        // Se esiste un tipo di progetto selezionato, assegna il type_id
        if (isset($data['type_id'])) {
            $project->type_id = $data['type_id'];
        }

        $project->user_id= $current_user;
        // Salva il nuovo progetto nel database
        $project->save();

        // Reindirizza alla pagina del progetto appena creato con un messaggio di successo
        return redirect()->route('admin.projects.show', $project->slug)->with('success', 'Project created successfully');
    }
    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //  $project = Project::where('slug', $slug)->first();
        // // Passa il progetto specifico alla vista
        return view('admin.project.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {

        //Questo codice recupera tutti i record dalla tabella types e li memorizza nella variabile $types.
        $types = Type::all();
        return view('admin.project.edit', compact('project', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        // Valida i dati della richiesta usando la classe UpdateProjectRequest
        $data = $request->validated();

        // Crea uno slug basato sul titolo aggiornato
        $data['slug'] = Str::of($data['title'])->slug('-');

        // Gestione dell'immagine di copertura
        if ($request->hasFile('cover_image')) {
            // Se è stata caricata una nuova immagine, elimina l'immagine esistente se presente
            if ($project->cover_image) {
                Storage::delete($project->cover_image);
            }

            // Salva la nuova immagine nella cartella 'cover_images' e ottieni il percorso
            $data['cover_image'] = $request->file('cover_image')->store('cover_images');
        } else {
            // Se non è stata caricata una nuova immagine, mantieni il vecchio percorso dell'immagine
            $data['cover_image'] = $project->cover_image;
        }

        // Aggiorna le proprietà del modello `Project` con i nuovi dati
        // Assegna i valori specifici per ogni campo
        $project->title = $data['title'];
        $project->description = $data['description'];
        $project->slug = $data['slug'];

        // Se è presente un ID di tipo, aggiorna la tipologia del progetto
        if (isset($data['type_id'])) {
            $project->type_id = $data['type_id'];
        }

        // Se è stata fornita una nuova immagine, aggiorna il percorso dell'immagine
        if (isset($data['cover_image'])) {
            $project->cover_image = $data['cover_image'];
        }

        // Salva le modifiche del progetto nel database
        $project->save();

        // Reindirizza alla pagina del progetto appena aggiornato con un messaggio di successo
        return redirect()->route('admin.projects.show', $project->slug)->with('success', 'Project updated successfully');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        // Elimina l'immagine dal filesystem se presente nel database
        if ($project->cover_image) {
            Storage::delete($project->cover_image);
        }
        // Elimina il progetto dal database
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }
}
