# The Daily Roar
### Authors: Alexander Fisher, Uko Ebreso, Pankati Patel, Kevin Parra-Olmedo, Nicholas Moffa

<details>
<summary>Table of Contents</summary>

1. [Summary](#Summary)
2. [Visuals](#visuals)
3. [Technologies](#technologies)
4. [What We Learned](#what-we-learned)
5. [Setup and Installation](#setup-and-installation)
6. [Usage](#usage)
7. [Code Examples](#code-examples)
8. [License](#license)
9. [Contact](#contact)

</details>

## Summary
A web application that serves as an email broadcasting system for Kean University's CS & IT Department.

## Features
- **Email Broadcasting**: Generates an email list for each email draft depending on selected filters of recipient criteria.
- **Email Interactivity Tracking**: Utilizes clever programming tricks with HTTP requests to track when an email is opened or when a hyperlink in the sent email is clicked.
- **Data Visualization**: Makes use of the Google Charts API to visualize email tracking analytics to easily analyze broadcasted email interactivity from the recipients
- **Student Database Upload via CSV**: Ability to upload a formatted CSV based on the provided template to enable automatic CSV-to-DB data transfer of student records.
- **Engaging CSS-based Web Design**: Enhances the user experience through an engaging web interface that gives off a nostalgic retro-gaming feel using custom-made animated pixel art imagery and the NES.css package.

## Visuals
<p float="left">
  <img src="https://raw.githubusercontent.com/alexfishy12/dailyroar/main/web/_assets/Keanu_Walk_GIF.gif" width="150" />
  <img src="https://raw.githubusercontent.com/alexfishy12/dailyroar/main/web/_assets/dailyroar_screenshot.png" width="100%" /> 
</p>
<p float="center">
  <img src="https://raw.githubusercontent.com/alexfishy12/dailyroar/main/web/_assets/dailyroar_stats_screenshot.png" width="100%" /> 
</p>

## Documentation
- [Final Report](web/_assets/documents/Daily%20Roar%20Final%20Report.docx.pdf)
- [Final Poster](web/_assets/documents/Capstone%20Poster.pdf)
- [Software Design Document](web/_assets/documents/Software_Design_Document_v1.1.docx.pdf)
- [Software Project Management Plan](web/_assets/documents/sw_project_mgt_plan_V%201.1.docx.pdf)
    - [Business Case](web/_assets/documents/business_case_V%201.0.docx.pdf)
    - [Project Description](web/_assets/documents/project_desc_text_V%201.0.docx.pdf)
    - [Statement of Work](web/_assets/documents/statement_of_work.docx.pdf)
- [Test Cases Sprint 1](web/_assets/documents/Test%20Cases%20Sprint%201.xlsx.pdf)
- [Test Cases Sprint 2](web/_assets/documents/Test%20Cases%20Sprint%202.xlsx.pdf)
- [User Stories Sprint 1](web/_assets/documents/User_Stories_Sprint1_v1.0.docx.pdf)
- [User Stories Sprint 2](web/_assets/documents/User_Stories_Sprint2_v1.0.docx.pdf)


## Technologies
- Front-end: HTML, CSS (with Bootstrap), Javascript, RichTextEditor API, Google Charts API
- Back-end: Linux OS, hosted on Digital Ocean Droplet (Virtual Private Server), MariaDB SQL Database, PHP server-side scripts

## What We Learned
- **Sending mail**: How to send emails using PHP.
- **RichTextEditor**: How to properly store a rich text email body in a database for reuse. 
- **Database Architecture**: How to structure a relational database to accomodate a real-world environment that deals with university faculty, students, emails, and email tracking data.
- **End-User Data Collection**: How to use automated HTTP requests upon email opening and link clicks which collect email interactivity data from students for faculty users to analyze. 

## Setup and Installation
1. Clone the repo: `git clone https://github.com/alexfishy12/dailyroar.git`
2. Download and install Docker:
   - Windows:  https://docs.docker.com/desktop/install/windows-install/
   - macOS: https://docs.docker.com/desktop/install/mac-install/
   - Linux: https://docs.docker.com/desktop/install/linux-install/
3. In the base project directory, create a `.env` file. Set the variable values to your liking. The values set below are shown as an example of what your file should look like.

    ```env
    // .env file

    PORT_WEB=5000
    PORT_DATABASE=5001
    PORT_PHPMYADMIN=5002
    MYSQL_USER=username
    MYSQL_PASSWORD=password
    ```

## Usage
1. Run docker compose: `docker compose up --build`
2. Use a browser to navigate to `http://localhost:[PORT_WEB]` for the daily roar site, and `http://localhost:[PORT_PHPMYADMIN]` for PHPMyAdmin for a direct interface with the backend SQL database.

## Code Examples
- **Append tracking link to each email sent**:

    ```php
    //attach tracking link
    $final_body = $new_link_body. '<img src="'.$base_url.'tracking.php?email_id='. $email_id .'&student_id='.$recipient["ID"].'&tracking_type=open" width="1" height="1" />';    
    ```
- **Modify hyperlinks to be tracked**: 

    ```php
     function replace_links($body, $email_id, $recipient_id) {
        // Create a new DOMDocument object
        $dom = new DOMDocument();

        // Load the HTML content into the DOMDocument object
        $dom->loadHTML($body);

        // Find all hyperlinks in the HTML content
        $links = $dom->getElementsByTagName('a');

        // Loop through each hyperlink and replace the link URL
        foreach ($links as $link) {
            $url = $link->getAttribute('href');
            $newUrl = 'https://obi.kean.edu/~fisheral/dailyroar/tracking.php?redirect_url=' . urlencode($url) . '&email_id='. $email_id .'&student_id='.$recipient_id . "&tracking_type=click";;
            $link->setAttribute('href', $newUrl);
        }

        // Get the updated HTML content from the DOMDocument object
        $body = $dom->saveHTML();
        return $body;
    }
    ```
- **Save tracking data to database**: 

    ```php
    $query;
    if ($tracking_type == "open") {
        $query = "UPDATE Tracking set Opened = 1 where StudentID = :student_id AND EmailID = :email_id;";
    }
    else {
        $query = "UPDATE Tracking set Clicked = 1 where StudentID = :student_id AND EmailID = :email_id;";
    }
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":student_id", $student_id);
    $stmt->bindParam(":email_id", $email_id);
    $stmt->execute();
    ```

## Contact
- Alexander J. Fisher
  - **Email**: alexfisher0330@gmail.com
  - **LinkedIn**: https://www.linkedin.com/in/alexjfisher

- Pankati Patel
  - **Email**: patpanka@kean.edu
  - **LinkedIn**: https://www.linkedin.com/in/pankatipatel

- Uko Ebreso
  - **Email**: ebresou@kean.edu
  - **LinkedIn**: https://www.linkedin.com/in/uko-ebreso-85b6091b4

- Kevin Parra
  - **Email**: parraolk@kean.edu
  - **LinkedIn**: https://www.linkedin.com/in/kevin-parra-5823401b8

- Nicholas Moffa
  - **Email**: moffan@kean.edu
  - **LinkedIn**: https://www.linkedin.com/in/nicholas-moffa

## Acknowledgments

We would like to thank Jing-Chiou Liou, Ph.D. (jliou@kean.edu) who advised us during our Spring 2023 Graduate Capstone for this project.

---
