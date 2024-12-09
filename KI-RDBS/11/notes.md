# 11 – ORM

https://martinfowler.com/bliki/OrmHate.html

the ORM is HARD / synchro between relational db tables and in-memory objects

what-if concurrent db access

relational dbs are here to stay, they won the war

https://maetl.net/talks/rise-and-fall-of-orm

///////////////////////
https://www.edgedb.com/blog/why-orms-are-slow-and-getting-slower
///////////////////////

SQLAlchemy
an ORM for Python
Philosophy

SQL dbs are not objects
Objects are not tables and rows
SQLAlchemy is the glue between the two

SQLAlchemy> db is a relational algebra engine (with joins, unions, etc)

SA ORM data mapper pattern that allows object model and db schema to be cleanly decoupled

Key features
Two components: Core and ORM
Core: abstraction layer over dbapi + SQL expression lang via Python generative
////////////////
geeks

data mapper pattern, not active record pattern llike other ORMs
2006

converts data between incompatible systems

each class maps to a table

multiple databases

Core / ORM

Core: SQL Expression Language (SQL statements in Python code)

connecting to database - engine

create table

complex, worse than SQL, to avoid writing SQL

session object - handle to database

leaky: text()

# default

engine = create_engine('postgresql://scott:tiger@localhost/mydatabase')

# psycopg2

engine = create_engine('postgresql+psycopg2://scott:tiger@localhost/mydatabase')

# pg8000

engine = create_engine('postgresql+pg8000://scott:tiger@localhost/mydatabase')

CHAT

Chat history

Open sidebar

ChatGPT

You said:
do you know sqlalchemy
ChatGPT said:
ChatGPT
Yes, I am familiar with SQLAlchemy! It's a powerful and popular Object-Relational Mapping (ORM) library for Python that allows developers to interact with databases using Python objects instead of writing raw SQL queries. It supports a wide variety of databases, such as PostgreSQL, MySQL, SQLite, and Oracle.

SQLAlchemy provides two main layers:

Core: A SQL Expression Language that gives fine-grained control over database operations.
ORM (Object Relational Mapper): Allows working with Python classes and objects to interact with database tables.
If you have specific questions or need help with SQLAlchemy, feel free to ask!

You said:
Yes. I understand that I can create Python classes and SQLAlchemy turns them into database tables.

ChatGPT said:
ChatGPT
Exactly! This feature is part of SQLAlchemy's ORM, which maps Python classes to database tables. Here's a quick overview of how it works:

Steps to Create Classes and Map Them to Tables
Define a Base Class
Use declarative_base() to define a base class. This is the foundation for all your mapped classes.

from sqlalchemy.orm import declarative_base

Base = declarative_base()
Create a Class for Each Table
Define your Python classes by inheriting from Base. Each class corresponds to a table, and the attributes of the class represent the columns.

from sqlalchemy import Column, Integer, String

class User(Base):
**tablename** = 'users' # Table name in the database

    id = Column(Integer, primary_key=True)
    name = Column(String, nullable=False)
    email = Column(String, unique=True, nullable=False)

Create the Database Schema
Use Base.metadata.create_all() to generate the database schema (the tables) based on your classes.

from sqlalchemy import create_engine

engine = create_engine('sqlite:///example.db') # SQLite database
Base.metadata.create_all(engine) # Create tables
Interact with the Database
Use a Session to query, add, or update data.

from sqlalchemy.orm import sessionmaker

Session = sessionmaker(bind=engine)
session = Session()

# Adding a new user

new_user = User(name="John Doe", email="john@example.com")
session.add(new_user)
session.commit()

# Querying the database

user = session.query(User).filter_by(name="John Doe").first()
print(user.email)
This approach is highly modular and helps maintain clean, Pythonic code when working with databases. Would you like more details on any specific aspect, such as relationships between tables, advanced queries, or managing migrations?

You said:
Now, when I create instances of my classes, will they aoutomaticaly be reflected in table rows?
ChatGPT said:
ChatGPT
No, simply creating instances of your classes in SQLAlchemy does not automatically reflect changes in the database tables. To persist the instances (i.e., add rows to the database), you must explicitly interact with a session. Here's how it works:

Workflow for Persisting Data to the Database
Create an Instance
Create a Python object of your mapped class. At this point, the object exists only in memory and is not yet reflected in the database.

new_user = User(name="Jane Doe", email="jane@example.com")
Add the Instance to the Session
Use the add() method of the session to stage the object for persistence.

session.add(new_user)
Commit the Session
Call session.commit() to finalize the transaction and save the staged changes (including the new row) to the database.

session.commit()
Optional: Flush Changes Immediately
You can use session.flush() to send changes to the database immediately without committing the transaction, but this is optional and typically used in advanced scenarios.

Example: Full Workflow

# Create a new instance

new_user = User(name="Jane Doe", email="jane@example.com")

# Add the instance to the session

session.add(new_user)

# Commit to save changes to the database

session.commit()

# Now, the instance represents a row in the database!

print(new_user.id) # SQLAlchemy automatically assigns the ID if it's auto-incrementing
Why Doesn't It Happen Automatically?
SQLAlchemy requires explicit actions like add() and commit() to:

Give developers control over when changes are made.
Allow grouping multiple operations into a single transaction.
Avoid accidental changes to the database from in-memory objects.
Would you like me to explain more about the session lifecycle, transactions, or any other details?

You said:
So, when I have one of my classes reference other classes, like as in representing a graph, how will that be refleccted in the table straucture?
ChatGPT said:
ChatGPT
When you want one class to reference another in SQLAlchemy, this typically represents a relationship between database tables. SQLAlchemy allows you to model relationships using foreign keys and the relationship() function, and it automatically reflects these relationships in the table structure.

Example: Representing a Graph-Like Structure
Let's say you're modeling a graph where nodes reference other nodes.

Table Structure
Nodes Table: Each node has a unique ID and may reference a parent node (or another node in the graph).
Relationships: This is done using foreign keys in the database and relationships in SQLAlchemy.
Code Example: Self-Referencing Relationship
from sqlalchemy import Column, Integer, String, ForeignKey
from sqlalchemy.orm import relationship, declarative_base

Base = declarative_base()

class Node(Base):
**tablename** = 'nodes'

    id = Column(Integer, primary_key=True)
    name = Column(String, nullable=False)
    parent_id = Column(Integer, ForeignKey('nodes.id'))  # Self-referencing foreign key

    # Relationship to the parent node
    parent = relationship('Node', remote_side=[id], backref='children')

    def __repr__(self):
        return f"<Node(id={self.id}, name={self.name}, parent_id={self.parent_id})>"

Explanation of the Code
ForeignKey('nodes.id'):
This creates a column (parent_id) that stores the ID of another node, representing the "parent" in the relationship.

relationship():

The parent relationship links this node to its parent.
The remote_side argument specifies which column on the Node class is the "other side" of the relationship (in this case, id).
The backref='children' creates a reverse relationship, allowing you to access all child nodes from the parent.
Table Schema
The above class generates a table structure like this:

id name parent_id
1 Root Node NULL
2 Child A 1
3 Child B 1
Example Usage
Adding Nodes to the Graph

# Add root node

root = Node(name="Root Node")
session.add(root)
session.commit()

# Add child nodes

child_a = Node(name="Child A", parent=root)
child_b = Node(name="Child B", parent=root)

session.add_all([child_a, child_b])
session.commit()
Querying the Graph

# Fetch the root node and its children

root = session.query(Node).filter_by(name="Root Node").first()
print(root.children) # Outputs: [<Node(id=2, name=Child A, parent_id=1)>, <Node(id=3, name=Child B, parent_id=1)>]

# Access the parent of a node

print(child_a.parent) # Outputs: <Node(id=1, name=Root Node, parent_id=None)>
How It Reflects in the Database
Nodes Table:
Each row represents a node, with the parent_id column storing the relationship.

Queries:
SQLAlchemy translates Python object interactions into SQL joins, making it easy to navigate graph-like structures.

Would you like help with more complex graphs, such as those involving many-to-many relationships or cyclic structures?

You said:
Supposing that I have the classes, have created instances and commited them in the database. Then, when I for example run my program again, how do I restore my instances from the rows in tables?
ChatGPT said:
ChatGPT
To restore instances from rows in database tables, you query the database using a SQLAlchemy session. SQLAlchemy translates rows into instances of your mapped classes, effectively "hydrating" them into Python objects.

Here's how you can do it:

1. Querying All Instances
   You can use the session.query() method to retrieve all rows from a table and create instances for them.

# Retrieve all rows from the `nodes` table as Node instances

all_nodes = session.query(Node).all()
for node in all_nodes:
print(node) 2. Querying Specific Rows
You can filter rows using filter() or filter_by() methods to query specific instances.

Example: Query by Name
node = session.query(Node).filter_by(name="Child A").first()
print(node) # Outputs: <Node(id=2, name=Child A, parent_id=1)>
Example: Query by ID
node = session.query(Node).get(1) # Get the Node with id=1
print(node.name) # Outputs: Root Node 3. Querying Relationships
If you've set up relationships (e.g., parent-child in the graph example), you can query and access related data seamlessly.

Example: Query Parent-Child Relationship

# Fetch a node and its children

root = session.query(Node).filter_by(name="Root Node").first()
print(root.children) # Outputs a list of child Node instances

# Fetch a child and its parent

child = session.query(Node).filter_by(name="Child A").first()
print(child.parent) # Outputs: <Node(id=1, name=Root Node, parent_id=None)> 4. Using Lazy Loading
By default, SQLAlchemy uses lazy loading for relationships. This means related objects (e.g., children or parents) are not loaded until explicitly accessed. You can control this behavior with lazy options in the relationship().

5. Advanced Querying with SQLAlchemy ORM
   You can perform more advanced queries, such as filtering based on relationships, joining tables, and aggregations.

Example: Filtering on Related Data

# Find all nodes with a parent named "Root Node"

nodes_with_root_parent = session.query(Node).join(Node.parent).filter(Node.parent.name == "Root Node").all()
print(nodes_with_root_parent)
Key Points to Keep in Mind:
Session Management: Always ensure the session is correctly set up and connected to the database when querying.
Instances from Rows: When rows are retrieved, they are converted into instances of your mapped classes.
Identity Map: SQLAlchemy ensures that the same row in the database corresponds to the same in-memory object during a session.
Would you like to see an example of session setup in a new program or learn more about query customization?

You said:
what is hydrating
ChatGPT said:
ChatGPT
In the context of SQLAlchemy (and ORMs in general), hydrating refers to the process of converting rows from a database table into instances of your Python classes. Each row in the database is transformed into an object that you can work with in your Python code.

Why Hydration?
Hydration bridges the gap between the relational database world (rows and columns) and the object-oriented programming world (classes and instances). Instead of dealing with raw SQL data structures, you work with Python objects that encapsulate the data and behavior related to that data.

How Hydration Works in SQLAlchemy
When you query the database with SQLAlchemy's ORM:

SQL Query Execution: SQLAlchemy executes a SQL query and fetches the rows from the database.
Mapping Rows to Objects: For each row, SQLAlchemy:
Uses the class you've defined (e.g., Node) to create an instance.
Populates the attributes of the instance with the values from the row.
Identity Map: If a row corresponds to an object that has already been loaded into memory, SQLAlchemy reuses the existing object instead of creating a new one. This ensures consistency.
Example: Hydration in Action
Suppose you have a Node table and corresponding Node class, and you've already inserted some rows. Now you want to query the data.

Query and Hydrate Instances
nodes = session.query(Node).all() # Executes SQL, fetches rows, and hydrates
for node in nodes:
print(node.name) # Access the hydrated Python object
What's Happening:
SQLAlchemy runs a query like:
SELECT \* FROM nodes;
For each row in the result:
Creates a new Node instance.
Assigns row values to the instance's attributes (e.g., id, name, parent_id).
Practical Benefits of Hydration
Object-Oriented Access: You work with Python objects instead of raw SQL data.
Relationship Navigation: You can easily traverse relationships, e.g., accessing node.children or node.parent.
Encapsulation: Methods and logic related to a table can be encapsulated within the class.
Would you like more examples of working with hydrated objects or an explanation of the reverse process (dehydration/saving objects back to the database)?

You said:
why is it called hydration
ChatGPT said:
ChatGPT
The term hydration in programming comes from the metaphor of "adding life" to something static or dry—like water hydrating a sponge. In the context of ORMs like SQLAlchemy:

A row from a database is considered "dry" or "static" data, usually just raw numbers, strings, or other values.
When this data is loaded into a class instance, it becomes a fully usable object, complete with attributes, methods, and potentially relationships. This process of "breathing life into" raw data by turning it into objects is called hydration.
Why This Metaphor Fits
Dry Data: Rows from a database are just collections of values; they lack context or behavior beyond their raw format.
Hydrated Object: A class instance is "rich" with attributes and behaviors, making the data dynamic and interactive.
For example:

A row from the database might look like:
(1, "Alice", "alice@example.com")
A hydrated object might look like:
<User(id=1, name='Alice', email='alice@example.com')>
Now you can interact with it as a Python object, calling methods or navigating relationships.
Opposite Process: Dehydration
When you take a Python object and convert it back into raw data (e.g., inserting or updating a database row), this is often called dehydration—removing the "life" or context and leaving just the static data.

Common Usage in Other Areas
The term hydration is also used in other contexts where static data is turned into something dynamic:

Frontend Web Development: Hydrating static HTML with JavaScript to make it interactive.
APIs: Turning JSON data into object instances in a client application.
Would you like to dive deeper into how this works in SQLAlchemy, or explore similar concepts elsewhere?

You said:
it seems to me that sqqlalchemy adds a layer of complexity. all that can be achieved easier using just, say psycopg and a bit of custom code
ChatGPT said:
ChatGPT
You're absolutely right that for some use cases, using a lightweight library like psycopg (for PostgreSQL) or other database adapters along with custom code can be simpler and more direct. SQLAlchemy introduces a layer of abstraction, which can indeed feel like unnecessary complexity if your project is small or you’re comfortable managing raw SQL queries.

Here’s a comparison to help clarify when SQLAlchemy’s additional complexity might be worth it, versus sticking to something like psycopg2 with raw SQL.

Pros of Using psycopg2 with Raw SQL
Simplicity and Explicit Control:

You write the exact SQL you need.
No additional abstraction to learn.
Lightweight:

No ORM overhead, fewer dependencies.
Faster for straightforward queries.
Transparency:

You always know what queries are being executed.
Easier to debug and optimize SQL directly.
Flexibility:

No need to adapt to ORM conventions or workarounds.
Perfect for projects with complex, custom SQL requirements.
Why SQLAlchemy Might Be Worth the Complexity
Object-Oriented Convenience:

SQLAlchemy lets you work with Python objects instead of juggling raw SQL queries and manually mapping rows to attributes.
Useful for larger projects where encapsulating logic in classes improves maintainability.
Relationship Handling:

Built-in tools for managing relationships (e.g., parent-child or many-to-many relationships) without writing complex SQL joins.
Database-Agnostic:

Switching databases is easier with SQLAlchemy because it abstracts away database-specific SQL syntax.
Easier Maintenance:

Large teams benefit from an ORM because it reduces boilerplate code for CRUD operations and keeps business logic cleaner.
Advanced Features:

Transactions, lazy loading, eager loading, and automatic schema generation make it powerful for complex applications.
Migrations:

With tools like Alembic (integrated with SQLAlchemy), managing database migrations is more streamlined.
Example Comparison: Inserting a User
Using psycopg2 (Raw SQL)
import psycopg2

conn = psycopg2.connect("dbname=example user=postgres")
cur = conn.cursor()

# Insert a new user

cur.execute("INSERT INTO users (name, email) VALUES (%s, %s) RETURNING id", ("Alice", "alice@example.com"))
user_id = cur.fetchone()[0]

conn.commit()
cur.close()
conn.close()

print(f"User ID: {user_id}")
Using SQLAlchemy ORM
from sqlalchemy.orm import sessionmaker
from sqlalchemy import create_engine

# Setup database and session

engine = create_engine("postgresql://postgres@localhost/example")
Session = sessionmaker(bind=engine)
session = Session()

# Create and add a user

user = User(name="Alice", email="alice@example.com")
session.add(user)
session.commit()

print(f"User ID: {user.id}")
When to Use psycopg2 with Custom Code
Small, simple projects where you just need a few queries.
Heavy reliance on raw SQL for performance-critical or complex queries.
You’re comfortable writing and managing SQL directly.
When to Use SQLAlchemy
Medium to large projects with lots of models, relationships, or shared logic.
Team projects where encapsulation and maintainability are critical.
When you want to avoid writing repetitive boilerplate for CRUD operations.
Ultimately, the choice comes down to project requirements and developer preference. SQLAlchemy is powerful and feature-rich, but if its abstraction doesn't provide value for your use case, sticking to psycopg2 (or another lightweight approach) can be more efficient and elegant.

Would you like help with a psycopg2-based approach, or do you want to explore SQLAlchemy further?

You said:
how does sqlalchemy compare to sqlobject
ChatGPT said:
ChatGPT
SQLAlchemy and SQLObject are both Object-Relational Mapping (ORM) libraries for Python, but they have different philosophies and capabilities. Here's a detailed comparison:

1. Core Philosophy
   SQLAlchemy: Focuses on flexibility and being a "SQL toolkit" in addition to an ORM. It allows developers to write complex SQL when needed while still offering ORM features. It supports both the ORM layer and a lower-level SQL Expression Language for fine-grained control.
   SQLObject: A simpler, opinionated ORM designed to make database interactions easier by abstracting away most SQL details. It prioritizes ease of use over flexibility.
2. Features and Capabilities
   Feature SQLAlchemy SQLObject
   Design Highly customizable and modular. Simple, with a focus on ease of use.
   Query Language SQL Expression Language and ORM queries. ORM queries only (less control over SQL).
   Relationships Powerful, with support for lazy loading, eager loading, and advanced joins. Basic support, less flexibility in joins and relationship handling.
   Database Support Wide variety of databases (PostgreSQL, MySQL, SQLite, Oracle, etc.). Limited but supports major ones like PostgreSQL, MySQL, SQLite.
   Transactions Fine-grained control over transactions. Basic transaction management.
   Schema Management Schema generation and migrations with Alembic. Built-in schema generation but lacks advanced migration tools.
   Custom SQL Easy to integrate raw SQL when needed. Limited ability to work with raw SQL.
   Performance More efficient for complex queries due to its fine-grained control. May be slower for complex queries due to abstraction.
3. Learning Curve
   SQLAlchemy: Steeper learning curve due to its flexibility and two layers (SQL Expression Language and ORM). However, it’s more rewarding for complex projects.
   SQLObject: Easier to learn and use. It's more beginner-friendly but may feel limiting in larger or more complex applications.
4. Popularity and Community Support
   SQLAlchemy: Highly popular with an active community and extensive documentation. Used in many modern Python projects.
   SQLObject: Less popular and has a smaller community. Development activity has slowed compared to SQLAlchemy.
5. Code Comparison
   SQLAlchemy
   from sqlalchemy import Column, Integer, String, create_engine
   from sqlalchemy.orm import declarative_base, sessionmaker

Base = declarative_base()

class User(Base):
**tablename** = 'users'
id = Column(Integer, primary_key=True)
name = Column(String, nullable=False)
email = Column(String, nullable=False)

engine = create_engine('sqlite:///example.db')
Base.metadata.create_all(engine)

Session = sessionmaker(bind=engine)
session = Session()

new_user = User(name="Alice", email="alice@example.com")
session.add(new_user)
session.commit()
SQLObject
from sqlobject import SQLObject, StringCol, connectionForURI, sqlhub

sqlhub.processConnection = connectionForURI('sqlite:///example.db')

class User(SQLObject):
name = StringCol()
email = StringCol()

User.createTable()

new_user = User(name="Alice", email="alice@example.com")
print(new_user.id) 6. When to Choose SQLAlchemy
You need advanced features (e.g., complex queries, relationships, transaction control).
You want flexibility to write raw SQL alongside ORM queries.
You’re working on a large or complex project that may grow over time. 7. When to Choose SQLObject
You’re working on a small or simple project.
You prefer an ORM that "just works" with minimal setup and complexity.
You’re a beginner looking for an easy entry point into using ORMs.
Conclusion
SQLAlchemy: Best for developers who want flexibility and need to handle complex use cases. It's ideal for large projects and teams.
SQLObject: Best for developers who prioritize simplicity and ease of use for smaller, straightforward projects.
Would you like to explore specific examples or a deeper dive into either library?

You said:
they say that sqlalchemy is a "leaky" abstraction. what does that mean
ChatGPT said:
ChatGPT
The term "leaky abstraction" comes from the idea that an abstraction, which is supposed to hide underlying complexity, sometimes "leaks" details of the implementation, forcing you to understand the underlying system to use it effectively. This concept was popularized by Joel Spolsky in his article "The Law of Leaky Abstractions".

When people say SQLAlchemy is a leaky abstraction, they mean:

1. SQLAlchemy Doesn't Completely Hide SQL
   SQLAlchemy abstracts database interactions into Python objects and methods, but you often need to understand and write raw SQL for certain tasks.
   Example:
   You might use SQLAlchemy's ORM for simple queries but switch to its SQL Expression Language or even raw SQL for more complex operations, such as intricate joins or performance tuning.
   Leak: You still need to know SQL well, even though the ORM is designed to abstract it.
2. Behavior Can Depend on the Database
   SQLAlchemy tries to be database-agnostic, but certain features behave differently depending on the database engine (e.g., PostgreSQL vs. SQLite).
   Example:
   SQLAlchemy might generate slightly different SQL for the same ORM query depending on the backend.
   Leak: You may need to understand the specific database's behavior and quirks to debug issues.
3. Relationships and Performance
   Abstracting relationships with SQLAlchemy is convenient, but it can lead to unexpected performance issues:
   Lazy Loading: Accessing a relationship might trigger a separate SQL query, potentially leading to N+1 query problems.
   Eager Loading: You can fix this by using joins, but you must know how to optimize them.
   Leak: You have to understand SQL joins and query execution plans to optimize performance, even though the ORM is supposed to handle relationships transparently.
4. Debugging Complex Queries
   When a query doesn't work as expected or performs poorly, the abstraction "leaks" because you need to:
   Examine the actual SQL being generated (str(query) or query.statement).
   Understand how that SQL maps to your database schema.
   Tune queries manually.
   Leak: You need SQL debugging skills to handle these situations.
5. Migrations and Schema Management
   SQLAlchemy does not natively handle schema migrations. You need to use a separate tool like Alembic, which adds another layer of abstraction.
   Leak: You must understand how database schemas work to resolve migration issues.
   Why This Leakiness Exists
   SQLAlchemy is not just an ORM; it's a SQL toolkit. Its design prioritizes flexibility over complete abstraction:

It doesn't try to "hide" SQL entirely because doing so would make it less powerful for complex use cases.
The leaks are intentional, as SQLAlchemy assumes developers are familiar with SQL and relational databases.
Should You Worry About the Leaks?
For Beginners: The leaks might make SQLAlchemy harder to learn compared to simpler ORMs like SQLObject or Django ORM.
For Experienced Developers: The leaks provide power and flexibility, making SQLAlchemy a good choice for complex projects where understanding SQL is inevitable.
Example of a Leak
Query with ORM

# Retrieve all users who have posts

users = session.query(User).filter(User.posts != None).all()
Generated SQL (Leak)
SELECT \* FROM users WHERE EXISTS (
SELECT 1 FROM posts WHERE posts.user_id = users.id
)
If this query performs poorly, you might need to:

Inspect the SQL (str(query)).
Tune the query or add an index in the database.
Rewrite the query in raw SQL for better performance.
Summary
SQLAlchemy is considered "leaky" because it doesn't fully shield you from the underlying database and SQL. This is by design, as SQLAlchemy aims to provide both abstraction for convenience and access to raw SQL for flexibility.

Would you like an example of troubleshooting a "leaky" SQLAlchemy abstraction?

You said:
is chatgpt available for people at ujep.cz
ChatGPT said:
ChatGPT

Searched 3 sites
At the University of J. E. Purkyně (UJEP), ChatGPT is available and can be utilized for various educational purposes. Students and educators can leverage ChatGPT for simplifying lesson preparation, answering questions on a broad range of topics, and enhancing language skills. The use of ChatGPT is encouraged to assist in learning and teaching processes, and it is accessible via university resources​
UJEP | Univerzita J. E. Purkyně
​
Perpetuum
.

For more details on accessing and utilizing ChatGPT at UJEP, you can visit their academic resources page​
Vědecká knihovna UJEP
.

ChatGPT can make mistakes. Check important info.
?
