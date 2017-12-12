import { NgModule,Component, OnInit, OnChanges, Input } from '@angular/core';
import { Apartment } from '../models/apartment';
import { ApartmentService } from '../services/apartment.service';

import {
      ReactiveFormsModule,
      FormsModule,
      FormGroup,
      FormControl,
      Validators,
      FormBuilder
} from '@angular/forms'


@Component({
  selector: 'app-apartment-add',
  templateUrl: './apartment-add.component.html',
  styleUrls: ['./apartment-add.component.scss']
})
export class ApartmentAddComponent implements OnInit {

  apartment: Apartment;
  aform: FormGroup;

  constructor(private apartmentService: ApartmentService) { }

  ngOnInit() {
    this.aform = new FormGroup({
      move_in_date: new FormControl('', [
        Validators.required
      ]),
      post_code: new FormControl('', [
        Validators.required,
        Validators.pattern("[0-9]*")
      ]),
      street: new FormControl('', [
        Validators.required
      ]),
      town: new FormControl('', [
        Validators.required
      ]),
      country: new FormControl('', [
        Validators.required
      ]),
      email: new FormControl('', [
        Validators.required,
        Validators.pattern("[^ @]*@[^ @]*")
      ])
    });
  }

  create() {
    const formModel = this.aform.value;
    const apartment: Apartment = {
      move_in_date: formModel.move_in_date,
      street: formModel.street,
      post_code: formModel.post_code,
      town: formModel.town,
      country: formModel.country,
      email: formModel.email
    };

    return apartment;
  }

  onSubmit() {
    this.apartment = this.create();
    this.apartmentService.addApartment(this.apartment);
  }
}
