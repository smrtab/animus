import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ApartmentShowComponent } from './apartment-show.component';

describe('ApartmentShowComponent', () => {
  let component: ApartmentShowComponent;
  let fixture: ComponentFixture<ApartmentShowComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ApartmentShowComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ApartmentShowComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
