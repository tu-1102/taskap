import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import axios from 'axios';

function formatDate(date) {
  const dt = new Date(date);
  const year = dt.getFullYear();
  const month = ("0" + (dt.getMonth() + 1)).slice(-2);
  const day = ("0" + (dt.getDate())).slice(-2);
  const hours = ("0" + (dt.getHours())).slice(-2);
  const minutes = ("0" + (dt.getMinutes())).slice(-2);
  const seconds = ("0" + (dt.getSeconds())).slice(-2);
  
  return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
}

let calendarEl = document.getElementById('calendar');
let calendar = new Calendar(calendarEl, {
  plugins: [ dayGridPlugin, timeGridPlugin, listPlugin ],
  initialView: 'dayGridMonth',
  customButtons: {
    openModalButton: {
      text: 'タスクの追加',
      click: function() {
        document.getElementById('modal').style.display = 'flex';
      }
    }
  },
  headerToolbar: {
    left: 'prev,next today',
    center: 'title',
    right: 'dayGridMonth,timeGridWeek,listWeek'
  },
  footerToolbar: {
    left: 'openModalButton'
  },
  height: 650,

  events: function(info, successCallback, failureCallback) {
    axios
        .post("/task/get", {
          start_date: info.start.valueOf(),
          end_date: info.end.valueOf(),
        })
        .then(function (response){
          calendar.removeAllEvents();
          successCallback(response.data);
        })
        .catch(function (error) {
          alert("タスクの表示に失敗しました。");
        })
  },
  eventClick: function(info) {
    console.log(info);
    document.getElementById("task_id").value = info.event.id;
    document.getElementById("delete-id").value = info.event.id;
    document.getElementById("task_title").value = info.event.title;
    document.getElementById("task_description").value = info.event.extendedProps.description;
    document.getElementById("start_date").value = formatDate(info.event.start);
    document.getElementById("end_date").value = formatDate(info.event.end);
    document.getElementById("task_color").value = info.event.backgroundColor;
    document.getElementById("modal-update").style.display = "flex";
  }
});

calendar.render();

window.closeModal = function(){
    document.getElementById('modal').style.display = 'none';
}

window.closeUpdateModal = function(){
    document.getElementById("modal-update").style.display = "none";
}

window.deleteEvent = function(){
  'use strict'

  if(confirm('削除すると復元できません。\n本当に削除しますか？')){
      document.getElementById('delete-form').submit();
  }
}