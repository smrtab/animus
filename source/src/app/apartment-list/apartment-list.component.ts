import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Apartment } from '../models/apartment';
import { ApartmentService } from '../services/apartment.service';

@Component({
  selector: 'app-apartment-list',
  templateUrl: './apartment-list.component.html',
  styleUrls: ['./apartment-list.component.scss']
})
export class ApartmentListComponent implements OnInit {

  apartments: Apartment[];

  constructor(private apartmentService: ApartmentService,
              private router: Router) {}

  ngOnInit() {
    this.getApartments();
  }

  getApartments(): void {
    this.apartmentService.getApartments()
        .subscribe(apartments => this.apartments = apartments);
  }

  onSelect(apartment: Apartment): void {
    this.router.navigateByUrl('/apartment/show');
  }
}
