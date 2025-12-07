<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Index: Mengambil semua task dan mengirimkannya ke halaman utama (index.blade.php). [cite: 50]
     */
    public function index()
    {
        $tasks = Task::all(); // Mengambil semua task [cite: 50]
        return view('index', compact('tasks'));
    }

    /**
     * Store: Menyimpan data task baru ke database. [cite: 51]
     */
    public function store(Request $request)
    {
        // 1. Validasi input [cite: 169, 170]
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
        ]);

        // 2. Simpan task baru
        Task::create($validated);

        // 3. Redirect dengan pesan sukses [cite: 117, 119]
        return redirect()->route('tasks.index')->with('success', 'Task Added Successfully');
    }

    /**
     * Edit: Menampilkan form edit task berdasarkan ID. [cite: 52]
     * @param Task $task - Menggunakan Route Model Binding untuk langsung mendapatkan objek Task
     */
    public function edit(Task $task)
    {
        // $task sudah otomatis diambil dari database berkat Route Model Binding
        return view('edit', compact('task'));
    }

    /**
     * Update: Memperbaharui data task yang dipilih. [cite: 57]
     * @param Request $request
     * @param Task $task - Menggunakan Route Model Binding
     */
    public function update(Request $request, Task $task)
    {
        // 1. Validasi input
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'status' => 'required|in:pending,completed', // Pastikan status hanya 'pending' atau 'completed'
        ]);

        // 2. Perbaharui data task
        $task->update($validated);

        // 3. Redirect dengan pesan sukses [cite: 117, 118]
        return redirect()->route('tasks.index')->with('success', 'Task Edited Successfully');
    }

    /**
     * Delete/Destroy: Menghapus data task yang dipilih. [cite: 58]
     * @param Task $task - Menggunakan Route Model Binding
     */
    public function destroy(Task $task)
    {
        // 1. Hapus task
        $task->delete();

        // 2. Redirect dengan pesan sukses [cite: 117, 120]
        return redirect()->route('tasks.index')->with('success', 'Task Deleted Successfully');
    }
}
