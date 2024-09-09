/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/JSP_Servlet/JavaScript.js to edit this template
 */


let editingTask=null;
const title=document.getElementById('title');
const desc=document.getElementById('desc');
const duedate=document.getElementById('duedate');
const taskList = document.getElementById('task-list');
const loader=document.getElementById('loader');

function validate(event){
    event.preventDefault();
    if(title.value===""||desc.value===""||duedate.value===""){
        alert('Please fill all the fields');
        return false;
    }
    else{
        loader.style.display='block';
        const loadingTIme=setTimeout(addOrEditTask, 3000);
    }
}
function addOrEditTask(){
    const xhr= new XMLHttpRequest();
    xhr.open('POST','TaskServlet',true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload=function(){
        if(xhr.status===200){
            if(editingTask){
              const c= confirm('Are you sure you want to Edit this task?');
                if(c){
                    editingTask.outerHTML = xhr.responseText;
                }
                else{
                    return;
                }
                editingTask=null;   
            }
            else{
                taskList.innerHTML += xhr.responseText;
            }
            loader.style.display='none';

            title.value='';
            desc.value='';
            duedate.value='';
        }
    };
    const data= `title=${encodeURIComponent(title.value)}&desc=${encodeURIComponent(desc.value)}&duedate=${encodeURIComponent(duedate.value)}`;
    xhr.send(data);
}
function editTask(button){
    const taskItem=button.closest('li');
    const taskTitle=taskItem.querySelector('.title').textContent;
    const taskDesc=taskItem.querySelector('.desc').textContent;
    const taskDueDate=taskItem.querySelector('.duedate').textContent;

    title.value=taskTitle;
    desc.value=taskDesc;
    duedate.value = taskDueDate;
    editingTask = taskItem;
}

taskList.addEventListener('change', function (event) {
    if (event.target.type === 'checkbox') {
        const taskItem = event.target.closest('li');
        const div = taskItem.querySelector('div');
        if (event.target.checked) {
            taskItem.classList.add('completed');
        } else {
            taskItem.classList.remove('completed');
        }
    }
});

function deleteTask(button){
    const taskItem=button.closest('li');
    const c= confirm('Are you sure you want to delete this task?');
    if(c){
        taskItem.remove();
    }
}
document.addEventListener('DOMContentLoaded', function(){
    const filters=document.querySelectorAll('.filter');
    filters.forEach(function(filter){
        filter.addEventListener('click',function(event){
           const tasks= document.querySelectorAll('.task-item');
           tasks.forEach(task=>{
//             const isCompleted=task.classList.contains('completed');
               const isCompleted = task.querySelector('input[type="checkbox"]').checked;

               switch(filter.textContent){
                    case 'All':
                        task.style.display='flex';
                        break;
                    case 'Pending':
                        task.style.display=isCompleted ? 'none':'flex';
                        break;
                    case 'Completed':
                        task.style.display=isCompleted ? 'flex':'none';
                        break;
               }
           });
        });
    });   
});
