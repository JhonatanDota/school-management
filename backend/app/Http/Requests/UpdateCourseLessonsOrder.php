<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Models\CourseLesson;

class UpdateCourseLessonsOrder extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $courseId = $this->route('id');

        return [
            'orders' => ['required', 'array', 'size:' . CourseLesson::where('course_id', $courseId)->count()],
            'orders.*' => [
                'integer',
                Rule::exists(CourseLesson::class, 'id')->where('course_id', $courseId),
            ],
        ];
    }

    /**
     * Get the custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'orders.*.exists' => 'Some of the provided orders are either invalid or do not belong to this course.',
        ];
    }
}
