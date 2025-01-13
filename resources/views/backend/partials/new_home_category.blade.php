<div class="p-3 mb-3 remove-parent" style="border: 1px dashed #e4e5eb;">
    <div class="row gutters-5">
        <div class="col">
            <select class="form-control aiz-selectpicker" name="home_categories[]" data-live-search="true" required>
                @php
                    $categories = \App\Models\Category::where('parent_id', 0)->with('childrenCategories')->get();
                @endphp
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->getTranslation('name') }}
                    </option>
                    @foreach ($category->childrenCategories as $childCategory)
                        @include('categories.child_category', ['child_category' => $childCategory])
                    @endforeach
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <button type="button" class="btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".remove-parent">
                <i class="las la-times"></i>
            </button>
        </div>
    </div>
</div>
