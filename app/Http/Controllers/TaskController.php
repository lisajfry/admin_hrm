<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('karyawan')->get();
        return view('task.index', compact('tasks'));
    }

    public function create()
    {
        $karyawans = Karyawan::all();
        return view('task.create', compact('karyawans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawans,id',
            'judul_proyek' => 'required|string',
            'kegiatan' => 'required|string',
            'status' => 'required|in:belum dimulai,dalam progres,selesai',
            'tgl_mulai' => 'nullable|date',
            'batas_penyelesaian' => 'nullable|date',
            'tgl_selesai' => 'nullable|date',
            'point' => 'nullable|numeric',
            'status_approval' => 'nullable|in:disetujui,ditolak,pending',

        ]);

        Task::create($request->all());

        return redirect()->route('task.index')->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $karyawans = Karyawan::all();
        return view('task.edit', compact('task', 'karyawans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawans,id',
            'judul_proyek' => 'required|string',
            'kegiatan' => 'required|string',
            'status' => 'required|in:belum dimulai,dalam progres,selesai',
            'tgl_mulai' => 'nullable|date',
            'batas_penyelesaian' => 'nullable|date',
            'tgl_selesai' => 'nullable|date',
            'point' => 'nullable|numeric',
            'status_approval' => 'nullable|in:disetujui,ditolak,pending',

        ]);

        $task = Task::findOrFail($id);
        $task->update($request->all());

        return redirect()->route('task.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('task.index')->with('success', 'Tugas berhasil dihapus.');
    }
}
