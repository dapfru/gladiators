                        Web Search engine
               WFSearch .PRO version 0.8 (for PHP)

  - fast, indexing searching
  - indexing by file content
  - using MySQL database
  - recursive indexing of subdirectories
  - disallowed and allowed filename lists
  - output to number of pages
  - "and" / "or" search logic
  - results are sorting by popularity
  - tags killing
  - header and footer templates
  - multi language interface
  - show time of search process

   This search engine was written with zero, with using original PHP and MySQL
documentation. As usually, in internet I did not find search engines by my needs.
And happen to to write all by myself. It was written during as a whole 12 days
of development (or 30 work hours).
   All, who uses this script are beta-testers. So, please talk to me about
all founded bugs and as possible how to fix them. In this case send to me
fixed source code based on last version of WFSearch .PRO engine.

                       How to set up engine
                       ~~~~~~~~~~~~~~~~~~~~
   Very easy tuning. Unix users must set rights to run scripts. Also you must
correct MySQL connection file (connect.php). You can easy tune interface (files
include/header.php and footer.php).
   First run - admin.php. Next having chosen language, follow the instructions.
Searching will be produced ONLY AFTER full indexing.


                  History of developing WFSearch .PRO
                  ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
20 Jan 2003 (Version 1.0 (PHP))
  * MySQL installing
  * Administrating
  * Administration authorization (sessions, md5)
  * Full indexing
  * Fresh indexing
  * Changing contents of indexed files
  * Search all words of query ("and" logic)
  * Search one of query words ("or" logic)
  * header anf footer templates
  * Show time of search process
  * Supporting of Russian and English language

25 Dec 2002 (Version is not specified)
  * Engine developing is started


                       WFSearch "ToDo" List
                       ~~~~~~~~~~~~~~~~~~~~
- remove $query that are smaller than 3 characters
- bugs when using ", &, ', <, >
- str_replace: replace to ereg_replace functions ???
- extended searching (with combination of conditions, sensitive to register)
- full logging
- extraction keywords from meta tags
- removing from index of files, more not existing
- removing javascript, vbscript ¨ â.¯.
- special processing in indexing the binary files (pictures, video, exe)
- exec indexing
- searching in names of files
- sorting the results on date or importance (popularity)
- searching in results of searching
- improvement of searching with temporary table (removing table after 15 minutes after last call)
- searching and fixing bugs


                         WFSearch BUG List
                         ~~~~~~~~~~~~~~~~~
- queries with ", &, ', <, >


_____________________________________________________________________________
Copyright (c) jID aka Zhelneen Eugeney, jid@perm.raid.ru, ICQ: 123271556

20 Jan 2003