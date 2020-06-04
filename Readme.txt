Author`s Information:
    Name: Nguyen Dong Dong
    Student ID: s3634096
    Application Link: https://gg-bucket.appspot.com

Summarize Application:
    The application contains five main web pages that provide different features in managing employee records and additionally their name frequency. For example:
        1. Home Page: This page provides all links to designed features such as checking records or viewing name frequency.

        2. View Record Page: On the left side, this page shows all stored record in a table with some basic fields e.g: ID, First Name, Last name, Gender, Age, 
        Address, Phone Number.On the other side, this page also handles user request on adding new employees as well as update/delete record links.

        3. Update Page: After selecting a specific employee in view record page and press update button, the user will be taken to this page to edit this 
        employee and update to the database.

        4. Delete Page: After selecting specific employee in view record page and press delete button, the user will be taken to this page to check and confirm
        the process.

        5. Frequency Page: this page adds additional information to the employee record. To elaborate, based on the provided database, each employee record will have two
        more columns to show their first name and last name frequency.

    Besides, on each above page, a navigation bar is designed to lead the user to three main pages which are Home, View Record, and Frequency Page.

Achievements:
    1. CRUD for employee record: the information of each employee is located inside an Employees.csv file which stored in a google bucket. Therefore, the user now can View, Add,
    Update and Delete records without the need for local storage.

    2. Filter feature: Users can filter employee records based on their gender and age. To elaborate:
        - Gender: Male or Female.
        - Age: Below 25, From 25 to 50 and Above 50
        
    3. Search feature: the user also can search the employee by their first or last name.

    4. Additional Data: Users can view additional data about the frequency of their employee name rely on another public source.

    5. Back to top button: In view employee page, when user have to scroll down to view records, there will be a button show up to help user get back to the top of page instantly.

Missing basic requirements: None

Future Improvement:
    1. Add pagination and order to all tables to improve the UI.
    2. More strict on validating the add form.
    3. Add the login page to the application.