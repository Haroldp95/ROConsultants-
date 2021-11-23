import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-footer',
  templateUrl: './footer.component.html',
  styleUrls: ['./footer.component.scss'],
})
export class FooterComponent implements OnInit {
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
}
