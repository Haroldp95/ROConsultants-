import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-nav-bar',
  templateUrl: './nav-bar.component.html',
  styleUrls: ['./nav-bar.component.scss'],
})
export class NavBarComponent implements OnInit {
  constructor() {}

  ngOnInit() {}

  //? Open home page.
  toHome() {
    console.log('Going Home...');
    location.replace('./index.html');
  }

  //? Open Login Screen.
  toLogin() {
    //Clear innertext
    document.getElementById('login').innerText = '';

    //Add Icon and new text.
    var tag = document.createElement('i');
    tag.className = 'fas fa-user-alt';
    tag.innerText = ' Uitloggen';
    var element = document.getElementById('login');
    element.appendChild(tag);

    //Change Class.
    document.getElementById('login').className = 'login';
  }
}
