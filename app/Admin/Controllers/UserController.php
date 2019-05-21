<?php

namespace App\Admin\Controllers;

use App\Model\FirmUser;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {

        return $content
            ->header('用户列表')
            ->description('列表')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new FirmUser);
        $grid->status()->switch();
        $grid->id('Id');
        $grid->firm_name('Firm name');
        $grid->firm_man('Firm man');
        $grid->firm_num('Firm num');
        $grid->appid('appid');
        $grid->key('key');
        $grid->firm_img('Firm img')->image();
        $grid->add_time('Add time');
        $states = [
            'on'  => ['value' => 1, 'text' => '通过', 'color' => 'primary'],
            'off' => ['value' => 2, 'text' => '未过', 'color' => 'default'],
        ];
        $grid->status('审批操作')->switch($states);
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(FirmUser::findOrFail($id));

        $show->id('Id');
        $show->firm_name('Firm name');
        $show->firm_man('Firm man');
        $show->firm_num('Firm num');
        $show->add_time('Add time');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new FirmUser);

        $form->text('firm_name', 'Firm name');
        $form->text('firm_man', 'Firm man');
        $form->text('firm_num', 'Firm num');
        $form->number('add_time', 'Add time');
        $states = [
            'on'  => ['value' => 1, 'text' => '通过', 'color' => 'primary'],
            'off' => ['value' => 2, 'text' => '未过', 'color' => 'default'],
        ];
        $form->switch('is_check', '状态')->states($states);
        return $form;
    }

    public function update(Request $request,$id){
        $arr=$request->input();
        if($arr['status']=='on'){
            $info=[
                'is_check'=>1,
                'appid'=>rand(1000000,9999999),
                'key'=>Str::random(6),
            ];
            DB::table('firm_user')->where('id',$id)->update($info);
        }


    }
}
