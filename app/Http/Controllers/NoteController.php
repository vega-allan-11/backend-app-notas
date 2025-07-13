<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class NoteController extends Controller
{
    // 1. Listar todas las notas del usuario autenticado
    public function index()
    {
        return FacadesAuth::user()->notes()->latest()->get();
    }

    // 2. Crear nueva nota
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string|max:5000',
        ]);

        $note = FacadesAuth::user()->notes()->create($data);

        return response()->json($note, 201);
    }

    // 3. Mostrar detalles de una nota
    public function show($id)
    {
        $note = FacadesAuth::user()->notes()->findOrFail($id);
        return response()->json($note);
    }

    // 4. Actualizar una nota
    public function update(Request $request, $id)
    {
        $note = FacadesAuth::user()->notes()->findOrFail($id);

        $data = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $note->update($data);

        return response()->json(['message' => 'Nota actualizada']);
    }

    // 5. Eliminar (soft delete) una nota
    public function destroy($id)
    {
        $note = FacadesAuth::user()->notes()->findOrFail($id);
        $note->delete();

        return response()->json(['message' => 'Nota eliminada']);
    }

    // 6. Buscar notas por texto
public function search($text, Request $request)
{
    $orderBy = $request->query('order', 'created_at');
    $direction = $request->query('direction', 'asc');

    $notes = auth()->user()
        ->notes()
        ->where('title', 'like', "%$text%")
        ->orWhere('content', 'like', "%$text%")
        ->orderBy($orderBy, $direction)
        ->get();

    return response()->json($notes);
}


    // 7. Ordenar notas por criterio (fecha o título)

    public function order($criteria, Request $request)
{
    if (!in_array($criteria, ['title', 'created_at'])) {
        return response()->json(['error' => 'Criterio inválido'], 400);
    }

    $direction = $request->query('direction', 'asc');

    if (!in_array(strtolower($direction), ['asc', 'desc'])) {
        return response()->json(['error' => 'Dirección inválida'], 400);
    }

    $notes = auth()->user()
        ->notes()
        ->orderBy($criteria, $direction)
        ->get();

    return response()->json($notes);
}

    public function toggleFavorite($id)
    {
        $user = auth()->user();
        $note = $user->notes()->findOrFail($id);

        $note->is_favorite = !$note->is_favorite;
        $note->save();

        return response()->json([
            'message' => 'Estado de favorito actualizado',
            'is_favorite' => $note->is_favorite
        ]);
    }
}
