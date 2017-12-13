import { Component, OnInit, Input, OnChanges, SimpleChanges, SimpleChange } from '@angular/core';
import {Apartment} from "../models/apartment";
import {ActivatedRoute} from "@angular/router";
import {Observable} from "rxjs/Observable";
import {ApartmentService} from "../services/apartment.service";
import {
    FormGroup,
    FormControl,
    Validators,
} from '@angular/forms'

declare var jquery:any;
declare var $ :any;

@Component({
  selector: 'app-apartment-edit',
  templateUrl: './apartment-edit.component.html',
  styleUrls: ['./apartment-edit.component.scss']
})
export class ApartmentEditComponent implements OnInit {

    @Input() apartment: Apartment;

    id: number;
    aform: FormGroup;

    constructor(private route: ActivatedRoute,
                private apartmentService: ApartmentService) { }

    ngOnInit() {
    }

    ngOnChanges(changes: SimpleChanges) {
        const apartment: SimpleChange = changes.apartment;
        console.log('prev value: ', apartment.previousValue);
        console.log('got name: ', apartment.currentValue);

        if (undefined !== apartment.currentValue) {
            this.apartment = apartment.currentValue;

            this.aform = new FormGroup({
                id: new FormControl(this.apartment.id, [
                    Validators.required
                ]),
                move_in_date: new FormControl(this.apartment.move_in_date, [
                    Validators.required
                ]),
                post_code: new FormControl(this.apartment.post_code, [
                    Validators.required,
                    Validators.pattern("[0-9]*")
                ]),
                street: new FormControl(this.apartment.street, [
                    Validators.required
                ]),
                town: new FormControl(this.apartment.town, [
                    Validators.required
                ]),
                country: new FormControl(this.apartment.country, [
                    Validators.required
                ]),
                email: new FormControl(this.apartment.email, [
                    Validators.required,
                    Validators.pattern("[^ @]*@[^ @]*")
                ])
            });
        }

    }

    onSubmit() {
        const formModel = this.aform.value;
        const apartment: Apartment = {
            id: formModel.id,
            move_in_date: formModel.move_in_date,
            street: formModel.street,
            post_code: formModel.post_code,
            town: formModel.town,
            country: formModel.country,
            email: formModel.email
        };
        this.apartmentService.updateApartment(apartment);

        $('#edit_appartment_modal').modal('hide');
    }
}
