<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BillRequest;
use App\Models\Bill;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;

/**
 * Class BillCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BillCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;
    use ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Bill::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/bill');
        CRUD::setEntityNameStrings('Hóa đơn', 'Danh sach hóa đơn');
        $less_10_day = Carbon::parse('Now +10 days');
        $this->crud->denyAccess(["show"]);
        $this->crud->addFilter([
            'type' => 'simple',
            'name' => 'remaining',
            'label' => 'Sắp hết hạn'
        ],
            false,
            function () use ($less_10_day) { // if the filter is active
                $this->crud->query->where("end", "<=", date($less_10_day))->where("end", ">=", now());
            });
        $this->crud->addFilter([
            'type' => 'simple',
            'name' => 'expired',
            'label' => 'Đã hết hạn'
        ],
            false,
            function () use ($less_10_day) { // if the filter is active
                $this->crud->query->where("end", "<", now());
            });
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addClause("where", "disable", 0);
        CRUD::column('student')->label("Học sinh");
        CRUD::column('staff')->label("Nhân viên thu");
        CRUD::column('method')->label("Phương thức")->options([
            'cash' => 'Tiền mặt',
            'card' => 'Chuyển khoản',
        ])->type("select_from_array");
        CRUD::column('amount')->label("Số tiền")->type("number")->suffix("đ");
        CRUD::column('start')->label("Bắt đầu")->type("date");
        CRUD::column('end')->label("Kết thúc")->type("date");
        CRUD::addColumn(
            [
//                'name' => 'Day',
                'label' => 'Thời gian còn lại',
                'type' => 'model_function',
                'function_name' => 'Day'
            ]);


        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(BillRequest::class);

        CRUD::addField([
            'name' => 'student_id',
            'label' => 'Học sinh',
            'model' => 'App\Models\Student',
            'entity' => 'Student',
            'type' => 'select2',
            'options' => (function ($query) {
                return $query->orderBy('name', 'ASC')->where('role', "user")->get();
            }),
        ]);
        CRUD::addField([
            'name' => 'staff_id',
            'value' => backpack_user()->id,
            'type' => 'hidden',
        ]);
        CRUD::field('amount')->type("number")->label("Số tiền");
        CRUD::field('start')->wrapper([
            'class' => 'col-md-6 col-12',
        ])->label("Ngày bắt đầu")->format("DD-MM-YYYY")->hint("Định dạng với ngôn ngữ tiếng anh là Tháng-Ngày-Năm");
        CRUD::field('end')->wrapper([
            'class' => 'col-md-6 col-12',
        ])->hint("Định dạng với ngôn ngữ tiếng anh là Tháng-Ngày-Năm");
        CRUD::field('end')->label("Ngày kết thúc");
        CRUD::field('method')->options([
            'cash' => 'Tiền mặt',
            'card' => 'Chuyển khoản',
        ])->type("select_from_array")->label("Phương thức");
        CRUD::field('image')->type("image")->label("Hóa đơn (nếu có)");

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function destroy($id)
    {
        Bill::find($id)->update([
            'disable' => 1,
        ]);
        return redirect()->back()->with("success", "Đã xóa thành công !");
    }
}
