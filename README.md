# FE21-CR13-Philip
Requirements
A global event management company needs a web application to track events. They would need to have a list of all their events with the following data:
- Event’s name
- Event’s date and start time
- Event’s description
- Event’s image (link to the image)
- Event’s capacity (number of people)
- Event’s contact e-mail
- Event’s contact phone number
- Event’s address (physical location, including street name and number, ZIP code and city name)
- Event’s URL
- Event’s Type (predefined list like “music”, “sport”, “movie”, “theater” etc.). Note: This is related to the bonus points, not necessary for the basic grading.

Create a nice looking responsive theme. You can use Bootstrap or just HTML/CSS.
Implement an interface for the CRUD on Events:
- Event index page: all events should be listed here like in the image above (event name, event date and time). Feel free to use Bootstrap cards to display the events.
- Event view page (details page): when a user clicks on the event card/button, an event view page with all the data from that specific event should be displayed.
-  Event edit page: on this page, it should be possible to edit the event data.
- Event add/create page: on this page, it should be possible to add a new event.
- Event delete option: a user should be able to delete an event from the database.

Please note that the file upload is not mandatory for this Code Review.

Bonus Points:
- Create filtering depending on the event type (hint: pass the information to the URL)
