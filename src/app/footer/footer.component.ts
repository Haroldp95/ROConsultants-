import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-footer',
  templateUrl: './footer.component.html',
  styleUrls: ['./footer.component.scss'],
})
export class FooterComponent implements OnInit {
  //? Links to Add
  navigations = [
    { name: 'Contact', icon: 'fas fa-file-signature', user: 'Harold de Boer' },
    { name: 'Over Ons', icon: 'fas fa-address-card', user: 'Daan Smets' },
    {
      name: 'Licenties',
      icon: 'fas fa-id-badge',
      user: 'Arend Kijkt in de Vegte',
    },
    {
      name: 'Privacy & Data',
      icon: 'fas fa-user-secret',
      user: '@2021 Deltion Zwolle',
    },
  ];

  constructor() {}

  ngOnInit() {}

  //? Open footer links.
  navigate(link) {
    switch (link) {
      case 'Contact':
        location.replace('./Webpages/contact.php');
        break;
      case 'About':
        location.replace('./Webpages/aboutus.php');
        break;
      case 'License':
        location.replace('./Webpages/license.php');
        break;
      case 'Privacy':
        location.replace('./Webpages/privacy.php');
        break;
    }
  }

  //? Switch on different links.
  toPage(name) {
    switch (name) {
      case 'Contact':
        break;
      case 'Licenties':
        break;
      case 'Licenties':
        break;
      case 'Privacy & Data':
        break;
    }
  }
}
