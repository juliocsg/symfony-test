**para ejecutar el proyecto ingrese a su dureccion local **por ejemplo C:\xampp\htdocs\test
Abra simbolo de Sistema y ejecute symfony server:start
Habra el postman y ejecute las siguentes instrucciones
/** persona **/

http://127.0.0.1:8000/person/create
http://127.0.0.1:8000/person/3/update?first_name=Walter&last_name=Rodriguez&doc_number=4546838
http://127.0.0.1:8000/person/1
http://127.0.0.1:8000/persons
http://127.0.0.1:8000/persons_search?first_name=Gustavo&doc_number=4546838&last_name=Rodriguez
http://127.0.0.1:8000/person/3/delete

/** empresa **/
http://127.0.0.1:8000/company/create
http://127.0.0.1:8000/company/1/update?name=Esteche Sistema
http://127.0.0.1:8000/company/1
http://127.0.0.1:8000/companies
http://127.0.0.1:8000/company_employee/2
http://127.0.0.1:8000/companies_search?name=Hola
http://127.0.0.1:8000/company/1/delete

/** empleado **/

http://127.0.0.1:8000/employee/create
http://127.0.0.1:8000/employee/1/update?company_id=2&person_id=2
http://127.0.0.1:8000/person_company/1
http://127.0.0.1:8000/employees
http://127.0.0.1:8000/employee/1/delete

/** número persona **/
http://127.0.0.1:8000/person_phone_number/create
http://127.0.0.1:8000/person_phone_number/1/delete

/** número empresa**/
http://127.0.0.1:8000/company_phone_number/create
http://127.0.0.1:8000/company_phone_number/1/delete