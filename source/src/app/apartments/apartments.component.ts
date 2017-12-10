import { Component, OnInit } from '@angular/core';
import { Apartment } from '../apartments/apartment';
import { ApartmentService } from '../services/apartment.service';

@Component({
  selector: 'app-apartments',
  templateUrl: './apartments.component.html',
  styleUrls: ['./apartments.component.scss']
})
export class ApartmentsComponent implements OnInit {

  apartments: Apartment[];

  constructor(private apartmentService: ApartmentService) {}

  ngOnInit() {
    this.getApartments();
  }

  getApartments(): void {
    this.apartmentService.getApartments()
        .subscribe(apartments => this.apartments = apartments);
  }
}
