<?php

namespace App\Http\Livewire\Admin\posts;

use App\Http\Extra\TableFunction;
use App\Models\Post;
use App\Models\Status;
use Livewire\Component;
use Livewire\WithPagination;

class PostIndex extends Component
{
    use TableFunction , WithPagination;

    public $paginationTheme = 'bootstrap';

    protected $listeners = ['delete' , 'forceDelete'  , 'restore' , 'selectedAction'];

    public $perPage = 15;
    public $status = '0';
    public $q = '';
    public $orderCol = 'created_at';
    public $ordering = 'desc';
    public $selected = [];
    public $action = 0;
    public $trash = 0;

    protected $queryString = ['perPage' => ['except' => 15] , 'status' => ['except' => '0'] , 'q' => ['except' => ''] , 'trash' => ['except' => 0] , 'orderCol', 'ordering'];

    public function mount()
    {
        $this->model = 'App\Models\Post';
        $this->softDelete = true;
    }

    public function render()
    {
        $conditions = [array('condition' => 'where' , 'key' => 'status_id' , 'value' => $this->status , 'except' => 0) , array('condition' => 'where' , 'key' => 'post_type' , 'value' => 'post' , 'except' => null) , array('condition' => 'order' , 'key' => $this->orderCol , 'value' => $this->ordering , 'except' => null)];
        if ($this->trash) {
            $conditions = array_merge($conditions , [array('condition' => 'trash' , 'key' => 'd' , 'value' => null , 'except' => null)]);
        }
        $posts = $this->getData($this->perPage , $this->q , collect($conditions));
        $statuses = Status::query()->where('type' , 1)->get();
        $perPages = [15 , 30 , 45 , 50];
        return view('Livewire.admin.posts.post-index' , compact('posts' , 'statuses' , 'perPages'));
    }

    public function changeStatus($id , $status)
    {
        $this->model::find($id)->update([
            'status_id' => $status
        ]);

        $this->dispatchBrowserEvent('toastMessage' , ['message' => 'وضعیت تغییر کرد.' , 'icon' => 'success']);
    }

    public function showTrash()
    {
        $this->trash = $this->trash == 0 ? 1 : 0;
    }

    public function actionMessage()
    {
        if (count($this->selected) > 0) {
            $this->dispatchBrowserEvent('message', ['message' => 'آیا میخواهید این عملیات انجام دهید؟', 'icon' => 'waring', 'title' => 'اطمینان دارید؟', 'btnCText' => 'بله', 'btnCAText' => 'لغو', 'event' => 'selectedAction', 'data' => null]);
        }
    }

    public function selectedAction()
    {
        if (count($this->selected) > 0) {
            switch ($this->action) {
                case 1:
                    foreach ($this->selected as $item) {
                        if ($this->trash ?? false) {
                            $this->forceDelete($item);
                            continue;
                        }
                        $this->delete($item);
                    }
                    $this->selected = [];
                    break;
                case 2:
                    foreach ($this->selected as $item) {
                        $this->restore($item);
                    }
                    $this->selected = [];
                    break;
            }
        } else {
            $this->dispatchBrowserEvent('toastMessage' , ['message' => 'موردی انتخاب نشده' , 'icon' => 'error']);
        }

        $this->action = 0;
    }
}
