import React from 'react';
import ReactDOM from 'react-dom';



class HeadDate extends React.Component {

    constructor(props) {
        super(props);
        this.list = props.dateDays.map((date) =>
            <div className="date-header" key={date.toString()}>
                {date}
            </div>
        );

    }

    render() {
        return (
            <div>
                {this.list }
            </div>
        );
    }
}

class Departments extends React.Component {
    constructor(props) {
        super(props);
        this.departments = props.departments.map((department) =>
        <div key={department.cid}>
            <div className="department-name" >
                {department.name}
            </div>
            <UsersContainer users={department.users} />
        </div>


        );
    }

    render() {
        return (
            <div className="department-all-row" >
                {this.departments }

            </div>
        );
    }
}
/*
 * <div class="department-container" v-for="department in departments">
 <div class="department-name">  @{{department.name}}</div>


 <div class="user-row" v-for="user in department.users">
 <div class="user-name">
 <div class="small">@{{user.name}}</div>
 </div>
 <div class="user-day " v-for="day in day_date">
 <slot-user class="slot  droppable"
 :data-user-id="user.id"
 :data-date="day"
 :data-slot="n"
 data-project-id=""
 v-for="n in 8"
 v-on:selectSlot="selectSlot"
 >@{{ n }}</slot-user>
 </div>

 <div class="clear"></div>
 </div>
 </div>
 <div class="clear"></div>
 * */

class UsersContainer extends React.Component {
    constructor(props) {
        super(props);

        this.users = props.users.map((user) =>
        <div key={user.cid}>
            <div >{user.name}</div>
            <UserDays/>
        </div>

        );
    }

    render() {
        return (
            <div className="users-container" >
                {this.users}
            </div>
        );
    }
}
class UserDays extends React.Component {
    constructor(props) {
        super(props);
        this.days = date.map((day)=>
            <div className="user-day " key={day}>

            </div>
        );
    }

    render() {
        return (
            <div className="user-row">
                <div className="user-name">
                    <div className="small">{user.name}</div>
                </div>
            </div>
        );
    }
}

class User extends React.Component {
    constructor(props) {
        super(props);
       this.user = propos.user;
    }

    render() {
        return (
            <div className="user-row">
                <div className="user-name">
                    <div className="small">{user.name}</div>
                </div>
            </div>
        );
    }
}


class Slot extends React.Component {
    constructor(props) {
        super(props);
        this.slot = {date: new Date()};
    }

    render() {
        return (
            <div>
                <h1>Hello, world 2!</h1>
                <h2>It is {this.state.date.toLocaleTimeString()}.</h2>
            </div>
        );
    }
}

// function App() {
//     return (
//         <div>
//             <Clock />
//             <Clock />
//             <Clock />
//         </div>
//     );
// }

// ReactDOM.render(
//     <App />,
//     document.getElementById('root')
// );

var date = [];

    $.ajax({
        url: 'http://dev.agency.brieuc.be/c/digitaslbi/planning/get',
        method: "GET",
        data: {},
        success: function (result) {
            //plannedTask = result;
            //addTaskPlannedOnView();
            date = result.dates;
            ReactDOM.render(
                <HeadDate dateDays={result.dates}/>,
                document.getElementById('date-container')
            );

            ReactDOM.render(
                <Departments departments={result.departments}/>,
                document.getElementById('department-root')
            );

        }
    });




