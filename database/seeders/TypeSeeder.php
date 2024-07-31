<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str; //importazione sluge

use function PHPSTORM_META\type;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //DISABILITARE LE CONSTRAINTI PER EVITARE CONFLITTI
        //Cosa fa: Disattiva temporaneamente le "constraint" (vincoli) di chiave esterna nel database.
        //Perché: Questo è utile quando vuoi fare modifiche significative alla struttura del database (come svuotare una tabella) senza che il database si lamenti di violazioni di vincoli.
        Schema::disableForeignKeyConstraints();


        //SVUOTA TABELLA PRIMA DI POPOLARLA
        //  Cosa fa: Cancella tutti i dati nella tabella types e resetta l'indice incrementale (ID) a 1.
        // Perché: Questo è utile quando vuoi ripopolare una tabella da zero, garantendo che non ci siano dati vecchi rimasti.
        Type::truncate();

        //ARRAY DI PARTENZA
        $types = ['Frontend', 'Backend', 'AI', 'Data Analytics', 'Fullstack'];

        //CREARE UN RECORD DELLA TABELLA ATTRAVERSO UN CICLO
        foreach ($types as $type) {
            //creare un instance del modello, NEWTYPE ASSEGNATO PER NON ANDARE IN CONFLITTO CON I NOMI
            $newType = new Type();

            $newType->title = $type;
            $newType->slug = Str::of($type)->slug();

            
            //salvare il record nella tabella
            $newType->save();
        }


        //REABILITARE LE CONSTRAINTI
        //Cosa fa: Riattiva i vincoli di chiave esterna nel database.
        //Perché: Dopo aver effettuato le modifiche desiderate,
        // riattivare i vincoli garantisce l'integrità referenziale dei dati, ovvero che le relazioni tra tabelle sono mantenute correttamente.
        Schema::enableForeignKeyConstraints();
    }
}
