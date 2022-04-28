<?php

namespace App\Http\Livewire\Admin\posts;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostFile;
use App\Models\Status;
use App\Models\Tag;
use App\Rules\ControlThumbs;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Livewire\Component;

class PostEdit extends Component
{
    public Post $post;

    public $file = [
        'url' => null,
        'alt' => null,
        'type' => null,
    ];

    public Collection $files;

    protected $listeners = ['upload' , 'changeFile'];

    public $selectedTag = [];

    public $categoryIds = [];

    public $deletedFiles = [];


    public function rules()
    {
        return [
            'post.title' => ['required' , 'string' , 'max:100'],
            'post.slug' => ['required' , 'string'  , Rule::unique('posts' , 'slug')->ignore($this->post->id)],
            'post.description' => ['nullable' , 'string' , 'max:10000'],
            'post.body' => ['nullable' , 'string'],
            'post.pin' => ['nullable' , 'boolean'],
            'post.comment' => ['nullable' , 'boolean'],
            'post.status_id' => ['required'],
        ];
    }

    public function mount()
    {
        $this->categoryIds = array_map('strval' , $this->post->categories()->pluck('id')->toArray());
        $this->selectedTag = $this->post->tags()->get();
        $this->files = collect($this->post->files()->get()->toArray());
    }

    public function render()
    {
        $categories = Category::query()->where('parent_id' , null)->where('category_type' , 1)->get();
        $statuses = Status::query()->where('type' , 1)->get();
        return view('Livewire.admin.posts.post-edit' , compact('categories' , 'statuses'));
    }

    public function getTags($q , $type) {
        return Tag::query()->where('name' , 'LIKE' , "%{$q}%")
            ->where('type' , $type)->get()->toJson();
    }

    public function addTags($tag)
    {
        $_tag = Tag::query()->where('name' , $tag)->first();
        if ($_tag) {
            return $_tag->toJson();
        }
        return Tag::query()->create([
            'name' => $tag,
            'type' => 1
        ])->toJson();
    }

    public function upload()
    {
        $this->validate([
            'file.url' => ['required'],
            'file.alt' => ['nullable' , 'string' , 'max:100'],
            'file.type' => ['required' , new ControlThumbs($this->files , 1)],
        ]);

        $this->files->push([
            'id' => null,
            'url' => $this->file['url'],
            'type' => $this->file['type'],
            'alt' => $this->file['alt']
        ]);

        $this->resetForm();
    }

    public function resetForm()
    {
        $this->file = [
            'url' => null,
            'alt' => null,
            'type' => null
        ];
    }

    public function deleteFile($index)
    {
        if ($this->files[$index]['id'] != null) {
            $this->deletedFiles = $this->files[$index]['id'];
        }
        $this->files->splice($index , 1);
    }

    public function generateSlug()
    {
        if (!$this->post->slug) {
            $this->post->slug = SlugService::createSlug(Post::class , 'slug' , $this->post->title);
        } else {
            $this->post->slug = str_replace(' ' , '-' , $this->post->slug);
        }
    }

    public function editFile($index)
    {
        $this->emit('getData' , ['value' => $this->files[$index] , 'index' => $index]);
        $this->dispatchBrowserEvent('open-modal');
    }

    public function changeFile($e)
    {
        $this->files->put($e['index'] , $e['value']);
        $this->dispatchBrowserEvent('toastMessage' , ['message' => 'فایل شما آپدیت شد.' , 'icon' => 'success']);
    }

    public function submit()
    {
        $this->validate();

        $this->post->save();

        if (count($this->deletedFiles) > 0) {
            PostFile::query()->whereIn('id' , $this->deletedFiles)->delete();
        }

        foreach ($this->files->whereNull('id') as $file) {
            PostFile::query()->create([
                'url' => $file['url'],
                'alt' => $file['alt'],
                'type' => $file['type'],
                'post_fileable_id' => $this->post->id,
                'post_fileable_type' => get_class($this->post)
            ]);
        }

        foreach ($this->files->whereNotNull('id') as $file) {
            PostFile::query()->find($file['id'])->update([
                'url' => $file['url'],
                'alt' => $file['alt'],
                'type' => $file['type'],
            ]);
        }

        $this->post->categories()->sync($this->categoryIds ?? []);

        $this->post->tags()->sync(collect($this->selectedTag)->pluck('id') ?? []);

        session()->flash('message' , ['title' =>  'پست شما با موفقیت ویرایش شد.' , 'icon' => 'success']);

        return redirect(route('admin.posts.index'));
    }
}
