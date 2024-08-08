<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Technology;
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
        $technologies = Technology::all();

        //Questo codice recupera tutti i record dalla tabella types e li memorizza nella variabile $types.
        $types = Type::all();
        // Passa i tipi di progetto alla vista attraverso compact ('types'), che li trasforma in array associativi.
        return view('admin.project.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        // Valida i dati della richiesta usando la classe StoreProjectRequest
        $data = $request->validated();

        $current_user = Auth::user()->id;

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

        $project->user_id = $current_user;
        // Salva il nuovo progetto nel database
        $project->save();
 

        //INSERIRE LA COMPILAZIONE DELLA TABELLA PIVOT DOPO LA CONVALIDAZIONE PER FAR SI DI ASSEGNARE UN IDENTIFICATIVO (ID) A TECHNOLOGIES
        // SE NELLA RICHIESTA è PRESENTE UNA TECHNOLOGIA
        if ($request->has('technologies')) {
            // Aggiunge le tecnologie selezionate alla tabella pivot
            $project->technologies()->attach($request->technologies);
        }

        // Reindirizza alla pagina del progetto appena creato con un messaggio di successo
        return redirect()->route('admin.projects.show', $project->slug)->with('success', 'Project created successfully');
    }
    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $technologies = Technology::all();
        //  $project = Project::where('slug', $slug)->first();
        // // Passa il progetto specifico alla vista
        return view('admin.project.show', compact('project', 'technologies'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $technologies = Technology::all();
        //Questo codice recupera tutti i record dalla tabella types e li memorizza nella variabile $types.
        $types = Type::all();
        return view('admin.project.edit', compact('project', 'types', 'technologies'));
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

        // Se è presente un ID di type, aggiorna la tipologia del progetto
        if (isset($data['type_id'])) {
            $project->type_id = $data['type_id'];
        }

        // Se è stata fornita una nuova immagine, aggiorna il percorso dell'immagine
        if (isset($data['cover_image'])) {
            $project->cover_image = $data['cover_image'];
        }

        // Salva le modifiche del progetto nel database
        $project->save();

        if ($request->has('technologies')){
            // Aggiorna le tecnologie del progetto con le nuove selezionate
            $project->technologies()->sync($request->technologies);
        }else{
            // Se non è stata fornita una nuova tecnologia, elimina le tecnologie associate al progetto
            $project->technologies()->detach();  // or $project->technologies()->delete();  // alternative method to detach all records, but not delete the pivot table records if needed.  The pivot table records will be deleted when you delete the project record.  If you want to keep the pivot table records, use detach() instead.  This method will also delete all the pivot table records.  The pivot table records will be deleted when you delete the project record.  If you want to keep the pivot table records, use detach() instead.  This method will also delete all the pivot table records.  The pivot table records will be deleted when you delete the project record.  If you want to keep the pivot table records, use detach() instead.  This method will also delete all the pivot table records.  The pivot table records will
        }

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

        //AVENDO GESTITA IN MANIERA PREVENTIVA LA CANCELLAZIONE DEI DATI PRESENTI NELLA TABELLA PIOVT DI TECNOLOGIES CASCADEONDELETE, 
        //IN QUESTO CASO NON CE NE SARà BISOGNO, MA è MEGLIO IN CASO NON SI CONOSCA IL CODICE ADATTARE UN MODO PREVENTIVO PER FAR SI CHE LA CANCELLAZIONE AVVENGA COMUNQUE NEL DB
        // // Se esistono tecnologie associate, elimina le relazioni con il progetto, modo 1
        // $project->technologies()->detach();
        //modo 2
        //$project->technologies()->sync([]); 
    }
}
