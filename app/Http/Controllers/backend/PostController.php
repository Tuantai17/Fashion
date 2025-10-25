<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Post;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function index()
    {
        $list = Post::select('id', 'title', 'slug', 'type', 'status', 'created_at', 'content', 'updated_at', 'thumbnail', 'description', 'detail')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('backend.post.index', compact('list'));
    }

    public function status($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return redirect()->route('post.index')->with('error', 'Bài viết không tồn tại.');
        }

        $post->status = ($post->status == 1) ? 0 : 1;
        $post->updated_by = Auth::id() ?? 1;
        $post->updated_at = now();
        $post->save();

        return redirect()->route('post.index')->with('success', 'Cập nhật trạng thái thành công!');
    }

    public function create()
    {
        return view('backend.post.create');
    }

    public function store(Request $request)
    {
        $slug = Str::slug($request->title);
        $existingPost = Post::where('slug', $slug)->first();
        if ($existingPost) {
            $slug .= '-' . Str::random(5);
        }

        $post = new Post();
        $post->title = $request->title;
        $post->slug = $slug;
        $post->description = $request->description;
        $post->detail = $request->detail;
        $post->content = $request->content;
        $post->status = $request->status ?? 1;
        $post->type = $request->type ?? 'post';
        $post->topic_id = $request->topic_id ?? 1;
        $post->created_by = Auth::id() ?? 1;

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '-' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/post'), $filename);
            $post->thumbnail = $filename;
        } else {
            $post->thumbnail = null;
        }

        $post->save();
        return redirect()->route('post.index')->with('success', 'Thêm bài viết thành công!');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('backend.post.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '-' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/post'), $filename);

            // Xóa ảnh cũ nếu tồn tại
            if ($post->thumbnail && file_exists(public_path('assets/images/post/' . $post->thumbnail))) {
                unlink(public_path('assets/images/post/' . $post->thumbnail));
            }

            $post->thumbnail = $filename;
        }

        $post->title = $request->title;
        $post->description = $request->description;
        $post->detail = $request->detail ?? '';
        $post->content = $request->content;
        $post->status = $request->status ?? 1;
        $post->topic_id = $request->topic_id;
        $post->updated_by = Auth::id() ?? 1;
        $post->save();

        return redirect()->route('post.index')->with('success', 'Cập nhật bài viết thành công!');
    }

    public function trash()
    {
        $list = Post::select('id', 'title', 'slug', 'thumbnail', 'status')
            ->orderBy('created_at', 'desc')
            ->onlyTrashed()
            ->paginate(5);

        return view('backend.post.trash', compact('list'));
    }

    public function restore($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore();
        return redirect()->route('post.trash')->with('success', 'Đã khôi phục bài viết');
    }

    public function destroy(string $id)
    {
        $post = Post::onlyTrashed()->find($id);
        if ($post == null) {
            return redirect()->route('post.trash');
        }

        $image_path = public_path('assets/images/post/' . $post->thumbnail);
        if ($post->forceDelete()) {
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        }
        return redirect()->route('post.trash');
    }

    public function delete(Post $post)
    {
        $post->delete();
        return redirect()->route('post.index');
    }

    public function detail($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return redirect()->route('post.index')->with('error', 'Không tìm thấy bài viết.');
        }

        return view('site.post.detail', compact('post'));
    }

    public function show($id)
    {
        $list = Post::findOrFail($id);
        return view('backend.post.show', compact('list'));
    }
}
