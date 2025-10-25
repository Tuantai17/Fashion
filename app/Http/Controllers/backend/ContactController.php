<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Http\Requests\StoreContactRequest;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = Contact::select('id', 'user_id', 'name', 'email', 'phone', 'title', 'content', 'reply_id', 'status', 'reply_content')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('backend.contact.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request)
    {
        
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contact = Contact::find($id);  // Tìm liên hệ theo ID

        if (!$contact) {
            return redirect()->route('contact.index')->with('error', 'Liên hệ không tồn tại');  // Nếu không tìm thấy, chuyển về trang danh sách
        }

        return view('backend.contact.show', compact('contact'));  // Trả về view với thông tin liên hệ
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

/*destroy---------------------------------------------------------*/
    public function destroy(string $id)
    {
        $contact = Contact::onlyTrashed()->find($id);
        if ($contact == null) {
            return redirect()->route('contact.trash');
        }

        // Xóa liên hệ vĩnh viễn khỏi cơ sở dữ liệu
        $contact->forceDelete();
        
        return redirect()->route('contact.trash');
    }
/*trash---------------------------------------------------------*/
    public function trash()
    {
        $list = Contact::select('id', 'user_id', 'name', 'email', 'phone', 'title', 'content', 'reply_id', 'status')
            ->orderBy('created_at', 'desc')
            ->onlyTrashed()  // Lấy các liên hệ đã bị xóa
            ->paginate(5);

        return view('backend.contact.trash', compact('list'));
    }

/*delete---------------------------------------------------------*/
public function delete($id)
{
    $contact = Contact::find($id);
    if ($contact == null) {
        return redirect()->route('contact.index');
    }

    // Xóa mềm (soft delete) liên hệ
    $contact->delete();
    return redirect()->route('contact.index');
}

/*status---------------------------------------------------------*/
public function status($id)
{
    $contact = Contact::find($id);
    if ($contact == null) {
        return redirect()->route('contact.index');
    }

    // Đảo ngược trạng thái của liên hệ
    $contact->status = ($contact->status == 1) ? 0 : 1;  // Nếu status là 1, đổi thành 0 và ngược lại
    $contact->updated_by = Auth::id() ?? 1;  // Ghi nhận người sửa đổi
    $contact->updated_at = now();  // Ghi nhận thời gian sửa đổi
    $contact->save();  // Lưu vào cơ sở dữ liệu

    return redirect()->route('contact.index');
}

/*restore---------------------------------------------------------*/
public function restore($id)
{
    $contact = Contact::onlyTrashed()->find($id);
    if ($contact == null) {
        return redirect()->route('contact.trash');
    }

    // Khôi phục liên hệ từ thùng rác
    $contact->restore();
    return redirect()->route('contact.trash');
}

// Hiển thị form trả lời
public function replyForm($id)
{
    $contact = Contact::findOrFail($id);
    return view('backend.contact.reply', compact('contact'));
}

// Xử lý form trả lời
public function replySubmit(Request $request, $id)
{
    $request->validate([
        'reply_content' => 'required|string',
    ]);

    $contact = Contact::findOrFail($id);
    $contact->reply_content = $request->reply_content;
    $contact->reply_id = Auth::id() ?? 1;
    $contact->updated_by = Auth::id() ?? 1;
    $contact->updated_at = now();
    $contact->save();

    return redirect()->route('contact.index')->with('success', 'Phản hồi đã được lưu.');
}


}
