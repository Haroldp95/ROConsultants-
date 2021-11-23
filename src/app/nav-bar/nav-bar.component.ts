import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-nav-bar',
  templateUrl: './nav-bar.component.html',
  styleUrls: ['./nav-bar.component.scss'],
})
export class NavBarComponent implements OnInit {
  navigations = [
    { name: 'Home', icon: 'fas fa-home' },
    { name: 'Contact', icon: 'fas fa-file-signature' },
    { name: 'Inloggen', icon: 'fas fa-address-card', id: 'login' },
  ];

  constructor() {}

  ngOnInit() {}

  //? Open home page.
  toHome() {
    console.log('Going Home...');
    location.replace('./index.html');
  }

  //? Open Login Screen.
  toLogin() {
    this.navigations[2].name = 'Uitloggen';
    this.navigations[2].icon = 'fas fa-user';

    //Change Class.
    document.getElementById('login').className = ' col-md-1 navBtnLogin';
  }

  //? Switch on different links.
  toPage(name) {
    switch (name) {
      case 'Home':
        this.toHome();
        break;
      case 'Contact':
        this.toHome();
        break;
      case 'Inloggen':
        this.toLogin();
        break;
    }
  }
}
