<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('index') }}
        </h2>
    </x-slot>
    <div id="calendar"></div>
    <div id="modal" class="modal-outside">
        <div class="modal-inside">
            <form method="POST" action="{{ route('task.create') }}">
                @csrf
                <label>タスク名</label>
                <input class="task-title" type="text" name="task_title"/>
                <label>説明</label>
                <textarea name="task_description"></textarea>
                <label>開始日時</label>
                <input class="task-date" type="datetime-local" name="start_date"/>
                <label>終了日時</label>
                <input class="task-date" type="datetime-local" name="end_date"/>
                <label>タスク色</label>
                <select name="task_color">
                    <option value="red" selected>赤</option>
                    <option value="blue" selected>青</option>
                    <option value="green" selected>緑</option>
                    <option value="orange" selected>橙</option>
                </select>
                <button type="button" onclick="closeModal()">キャンセル</button>
                <button type="submit">決定</button>
            </form>
        </div>
    </div>
    <div id="modal-update" class="modal-outside">
        <div class="modal-inside">
            <form method="POST" action="{{ route('task.update') }}">
                @csrf
                @method('PUT')
                <input id="task_id" type="hidden" name="task_id" value="" />
                <label>タスク名</label>
                <input id="task_title" class="task-title" type="text" name="task_title" value=""/>
                <label>説明</label>
                <textarea id="task_description" class="task_description" name="task_description"></textarea>
                <label>開始日時</label>
                <input id="start_date" class="task-date" type="datetime-local" name="start_date" value=""/>
                <label>終了日時</label>
                <input id="end_date" class="task-date" type="datetime-local" name="end_date" value=""/>
                <label>タスク色</label>
                <select id="task_color" class="task-color" name="task_color">
                    <option value="red">赤</option>
                    <option value="blue">青</option>
                    <option value="green">緑</option>
                    <option value="orange">橙</option>
                </select>
                <label><input type="radio" name="is_completed" value="true"/>タスク完了</label>
                <label><input type="radio" name="is_completed" value="false" checked/>タスク未完了</label>
                <button type="button" onclick="closeUpdateModal()">キャンセル</button>
                <button type="submit">決定</button>
            </form>
            <form id="delete-form" method="POST" action="{{ route('task_delete') }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="delete-id" name="id" value="" />
                    <button class="delete" type="button" onclick="deleteEvent()">削除</button>
                </form>
            </div>
    </div>
    <style>
        .modal-outside{
            display: none;
            justify-content: center;
            align-items: center;
            position: absolute;
            z-index: 10;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            height: 100%;
            width: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        .modal-inside{
            background-color: white;
            height: 400px;
            width: 600px;
            padding: 20px;
        }
        input{
            padding: 2px;
            border: 1px solid black;
            border-radius: 5px;
        }
        .task-title{
            display: block;
            width: 80%;
            margin: 0 0 20px;
        }
        .task-date{
            width: 27%;
            margin: 0 5px 20px 0;
        }
        textarea{
            display: block;
            width: 80%;
            margin: 0 0 20px;
            padding: 2px;
            border: 1px solid black;
            border-radius: 5px;
            resize: none;
        }
        select{
            display: block;
            width: 20%;
            margin: 0 0 20px;
            padding: 2px;
            border: 1px solid black;
            border-radius: 5px;
        }
        .fc-event-title-container{
            cursor: pointer;
        }
    </style>
</x-app-layout>