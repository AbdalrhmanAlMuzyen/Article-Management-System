# 📝 Scriptor - Article Management System

The **Article Management System** is a fully-featured platform designed to **streamline content creation, management, and engagement**.  
It provides a seamless experience for **users, writers, and administrators**, allowing them to manage articles, categories, user roles, interactions, and analytics in a **secure and efficient environment**.

This system is built with **Laravel** and follows modern best practices to ensure **maintainability, scalability, and performance**.  
It combines **user-friendly interfaces** with **powerful backend features**, making it suitable for **multi-author blogs, content platforms, and editorial workflows**.

_________________________________________________________________________________________________________________________________


## Key Features

- **User Authentication:** Secure login, registration, and session management.  
- **Role-Based Access:** Supports admins, editors, writers, and readers. 
- **Article Management:** Full CRUD for posts with approval workflow and publishing control.  
- **Categories & Tags:** Organize content effectively for better navigation and discovery.  
- **Likes & Follows:** Engage users with interactive features like liking posts and following writers.  
- **Author Requests:** Enable users to request elevated roles (e.g., writer) with admin approval.  
- **Search & Discovery:** Powerful search by users, titles, and content.  
- **Analytics & Statistics:** In-depth insights on users, posts, followers, engagement, and growth.  
- **Notifications:** Real-time alerts for post approvals, role changes, and other important events.  
- **Profile Management:** View and update personal profiles securely.  

______________________________________________________________________________________________________________________________

## 🛠 Tools & Technologies

This project is built with **Laravel**, leveraging its expressive syntax and modern PHP features.  
The system is designed with **clean, maintainable, and scalable architecture**, following best practices for production-ready applications.

### Core Technologies

- **Framework:** Laravel – provides an elegant MVC structure and robust features for rapid development.  
- **Database:** MySQL – reliable relational database for storing users, posts, categories, likes, and more.  
- **Authentication:** JWT-based authentication for secure, stateless user sessions.  
- **DTOs (Data Transfer Objects):** Ensures clean and validated data flow between controllers and services.  
- **Repositories & Services:** Decoupled layers for maintainability, testability, and separation of concerns.  
- **Traits:** Reusable traits encapsulate common functionalities to avoid repetitive code (DRY principle).  
- **Carbon:** Handles date and time calculations efficiently for subscriptions, posts, and analytics.  

### Coding Practices

- **Clean Code:** All modules follow consistent naming, formatting, and design conventions.  
- **Layered Architecture:** Controllers, repositories, services, and DTOs are separated for better maintainability.  
- **Reusability:** Common logic is abstracted into traits and shared services to reduce duplication.  
- **Scalability:** The system structure allows for easy extension with new modules or features.  
- **Robust Error Handling:** All operations are wrapped with proper exception handling and database transactions where necessary.


________________________________________________________________________________________________________________________________

# 🔐 Authentication

This section manages all authentication-related operations in the system, including account creation, login, and logout using JWT-based authentication.

## Features

### Register
Creates a new user account after validating the submitted data to ensure accuracy and security.

### Login
Verifies the provided credentials and returns a JWT token upon successful authentication.  
The token is then used for secure communication with protected API endpoints.

### Logout
Invalidates the current JWT token, ensuring the user’s session is completely closed.

## Security Enhancements

### 🔐 Rate Limiting
The login endpoint is protected with a rate limit of **5 attempts per minute**, helping prevent brute-force attacks and enhancing system security.

________________________________________________________________________________________________________________________________


# ✍️ Author Requests

The Author Request module allows users to apply for author privileges within the system.  
It provides a structured workflow where users can submit requests, view their request history, and administrators can review, approve, or reject them.  
All actions are handled securely with notifications sent at every important step.

## Features

### Submit Author Request
A user can submit a request to become an author.  
To prevent spam or repeated submissions, the system checks if the user has already submitted a pending request within the last **25 days**.  
If not, the request is created and marked for review.

### View My Author Requests
Users can view all the author requests they have submitted, along with their statuses (**pending, approved, rejected**).  
This helps users track the progress of their applications.

### View All Author Requests
Administrators can retrieve all author requests from all users, making it easy to manage and review incoming applications.

### Handle Author Request (Approve / Reject)
Administrators can process each request by approving or rejecting it.  
If a request is approved, the user is automatically granted the **writer role**.  
Every operation is wrapped in a secure database transaction to ensure data integrity.

### Automatic Notifications
After a request is handled, the user immediately receives a notification.  
The system generates a customized message depending on whether the request was approved or rejected, ensuring clear communication.

## Notes

- Users cannot spam author requests thanks to the **25-day cooldown** on pending applications.  
- Requests are processed safely with full validation and transaction support.  
- Notification messages are dynamic and tailored to keep users informed about their status.  
- The system ensures a smooth promotion flow from **regular user → writer**.

________________________________________________________________________________________________________________________________


# 🗂️ Categories Management

The Categories module provides a clean and efficient way to manage content classification within the system.  
It allows administrators to create, update, delete, and analyze categories, ensuring that posts remain well-organized and easy to navigate.

## Features

### Create Category
Administrators can create new categories by simply specifying a name.  
This helps keep the platform structured and allows authors to categorize their posts properly.

### Update Category
Existing categories can be renamed at any time.  
This is useful when adjusting naming conventions or reorganizing how content is grouped.

### Delete Category
Categories can be removed when they are no longer needed.  
The system ensures clean and consistent handling of category removal to maintain data accuracy.

### Retrieve Categories with Insights
When fetching categories, the system provides detailed insights for better content analysis:

- **Post Count (c):** The total number of posts belonging to each category.  
- **Total Likes (s):** The combined number of likes received by posts in the category.

Categories are automatically sorted by:

1. Most posts, and then  
2. Most likes  

ensuring that the most active and engaging categories appear at the top.

## Notes

- Ideal for platforms that require strong content organization such as blogs, news systems, and article-based applications.  
- The statistical data (post count & likes sum) helps administrators understand which categories are most active and most engaging.  
- Provides a balance between simple management operations and powerful analytical insights.

________________________________________________________________________________________________________________________________


# 📝 Posts Management

The Posts module provides a full suite of tools for writers and moderators to manage article creation, editing, publishing, and moderation.  
It ensures a clean workflow where writers can focus on content, while moderators maintain quality and approval standards.

## Features

### ➕ Create Post
Users with writing permissions can create new posts by submitting a title, content, and category.  
The post is saved instantly and returned with all its details.  
This allows writers to draft and build their articles efficiently.

### 📄 Get My Posts
Writers can retrieve all the posts they have authored.  
Filters such as title or date can be applied, allowing writers to quickly find and manage their own content.  
If no posts exist, a clear message is returned.

### ✏️ Update Post
Writers or moderators can update a post’s title or content.  
Only the fields that include new data are updated, keeping the system clean and preventing unnecessary overwrites.

If a moderator performs the update and provides a message, the post owner receives a custom notification explaining the update and the reason behind it—ensuring transparency.  

All updates are processed inside a database transaction to guarantee safe and consistent changes.

### 🗑️ Delete Post
Posts can be deleted by moderators or authorized users.  
Once removed:

- The system deletes it safely inside a transaction.  
- If a note/message is provided, the original author receives a notification informing them that their post was removed and why.  

This ensures a fair, professional moderation process.

### 📤 Submit for Publishing (Publish Request)
Once a writer finishes drafting a post, they can send it for review.  
This marks the post as pending, notifying the moderation team that the article is ready for evaluation.  

The post remains unchanged, but its status signals that it’s waiting for approval.

### ⏳ Get Pending Posts
Moderators can retrieve all posts awaiting review.  
If no posts are pending, the system clearly returns an empty list, keeping the moderation dashboard clean and intuitive.

### ✔️ Handle Post Approval (Approve / Reject)
Moderators can approve or reject any pending post.  
Once a decision is made:

- The post’s status is updated accordingly.  
- The author receives an automatic notification containing a customized message based on approval or rejection.  

All actions are wrapped inside a secure transaction to ensure data integrity.  

This workflow ensures professional editorial control while keeping authors informed about every decision.

## Notes

- All post operations are validated and processed securely with detailed error handling.  
- Writers stay informed through real-time notifications for updates, deletions, approvals, and rejections.  
- The publishing workflow ensures high content quality while giving authors a smooth experience.

_________________________________________________________________________________________________________________________________


# 🏠 Home Feed

The Home Feed delivers a smart, personalized content experience for each user.  
It blends posts from new creators, followed writers, and trending posts—ensuring a dynamic and engaging feed that always feels fresh.

The system intelligently selects up to 200 posts for each category the user browses, then distributes them across different content types to create a rich and balanced timeline.

## ✨ Feed Structure

To create the best user experience, the feed is split into three main sections:

### 🆕 1. New Creators (30%)
This section highlights posts from new and emerging creators.  
The system identifies users who joined the platform within the last 15 days, and selects their newest posts from the last 7 days.

**Purpose:**
- Encourage discovery  
- Spotlight fresh talent  
- Give new writers exposure and growth opportunities  

Posts are delivered in random order to maximize diversity.

### 👥 2. Following Feed (40%)
This part of the feed focuses on posts from users that the viewer already follows.  
It retrieves their latest posts from the past 7 days, ordered by recency.

**Purpose:**
- Strengthen user connections  
- Show familiar and trusted content  
- Keep the audience engaged with creators they care about  

This is the most personalized part of the feed.

### 🔥 3. Trending Posts (Remaining %)
Whatever is left from the 200-post limit is filled with trending content.  
These posts:
- Come from creators the user does not follow  
- Are from the last 7 days  
- Are ordered by likes_count (most liked first)  

**Purpose:**
- Expand user horizons  
- Introduce popular posts  
- Blend viral content with personalized recommendations  

This creates the perfect combination of personal + popular.

## 📌 Final Output

The feed returns three separate curated lists:

json :
{
    "trendingPosts": [...],
    "newCreatorsPosts": [...],
    "followingPosts": [...]
}

## 📌 Display Options

The client app can display the feed in multiple ways according to preference:

- **Combined as a single feed**  
- **Shown as individual sections**  
- **Mixed or reordered visually**

---

## 💡 Why This Feed Design?

- **Balances personal relevance with discovery**  
- **Prevents echo chambers**  
- **Promotes new creators**  
- **Highlights top-performing posts**  
- **Keeps the platform fresh and engaging every day**

This design results in a **premium, algorithm-enhanced content experience**, similar to major social platforms.

_________________________________________________________________________________________________________________________________

## ❤️ Likes System

The Likes module provides an interactive and real-time engagement experience for posts across the platform.  
It ensures smooth toggling between like/unlike actions, accurate counts, and clear visibility of users who liked each post.  

This feature is optimized for **performance, consistency, and user satisfaction**.

---

### 👍 Toggle Like / Unlike

Users can like or unlike any post with a single action. When the user interacts with the like button:

1. The system checks whether the post exists.  
2. It determines if the user has already liked the post.  
3. Based on the current state:
   - If the post was not liked, it registers a new like.  
   - If the post was already liked, it removes the like.  

The post’s `likes_count` is updated instantly to reflect the new state.  
All operations are handled inside a **transaction** for maximum reliability.  

The response clearly returns whether the post was liked or unliked successfully.

---

### 👥 Get Post Likers

This endpoint returns a list of all users who liked a particular post.  

- If the post has no likes, the system returns an empty list with a friendly message.  
- If likes are found, each user is returned with their relevant public info, making it easy to display likers inside the app.  

This improves post transparency and helps highlight popular engagement.

---

### Notes

- Every like/unlike action is completely reversible with a single toggle — no duplicate records, no inconsistencies.  
- Like counters remain accurate at all times thanks to real-time updates.  
- All operations include full validation and clean error handling to ensure a stable experience.  
- The system is optimized for **high-engagement environments** where posts receive constant interaction.

_________________________________________________________________________________________________________________________________


## 👥 Followers & Following

The Followers module enables social connections between users, allowing them to follow and stay updated with each other’s posts.  
It promotes **engagement, content discovery, and community building** within the platform.

---

### 🔄 Toggle Follow / Unfollow

Users can follow or unfollow other users seamlessly:

1. The system checks if the target user exists.  
2. Determines whether the current user is already following them.  
3. Toggles the following status accordingly:
   - **Follow**: Adds the user to the follower’s list.  
   - **Unfollow**: Removes the user from the follower’s list.  

The response clearly indicates whether the action was a follow or an unfollow.

---

### 📋 Get My Followers

Users can view a list of their followers:

- Returns all users who are following the current user.  
- If no followers exist, a clear message is displayed.  
- Provides visibility into who engages with the user’s content.  

This helps users understand their audience and build stronger connections.

---

### Notes

- Following/unfollowing is **instant and reversible**.  
- The system ensures **data consistency** and prevents duplicate or erroneous records.  
- Supports dynamic social interactions that encourage **engagement and content sharing**.  
- Lays the foundation for advanced features like personalized feeds, notifications, and trending creators.

_________________________________________________________________________________________________________________________________

## 🔍 Search System

The Search module allows users to quickly and efficiently find content and other users within the platform.  
It provides a **flexible, intelligent, and fast search experience** that enhances content discovery and engagement.

---

### 🔹 Search Types

The system supports multiple types of searches based on the user’s query:

1. **Search Users**
   - Finds users by full name (first name + last name).  
   - Excludes users with special roles that should not appear in public search (e.g., admins or moderators).  
   - Results are ranked by the number of posts first, then alphabetically by first and last name.  
   - Provides a clear overview of active and prolific users for easy discovery.

2. **Search by Post Title**
   - Finds posts containing the search term in the title.  
   - Results are returned in random order to ensure variety and exposure for different posts.

3. **Search by Post Content**
   - Finds posts containing the search term in the content/body.  
   - Results are also randomized, giving users diverse content beyond titles.

---

### Notes

- The search system is **fast, flexible, and user-friendly**.  
- Supports both **user and content discovery** in one unified interface.  
- Smart ranking and filtering ensure the **most relevant and active results** are surfaced first.  
- Perfect for platforms that host **articles, blogs, or social content** with multiple creators.

_________________________________________________________________________________________________________________________________


## 📊 Follower Statistics

The Follower Statistics module provides **deep insights into a user’s audience and engagement trends**.  
It allows users and administrators to analyze follower growth, engagement patterns, and top-performing posts with a focus on social influence and activity.

---

### 📈 Followers Growth

Tracks the growth of followers over time, with flexible grouping:

- **Daily:** Shows the number of new followers each day.  
- **Monthly:** Aggregates follower growth per month.  
- **Yearly:** Aggregates follower growth per year.

This allows users to **visualize trends, identify peaks, and understand how their audience is expanding** over different periods.

---

### 🏆 Top Posts by Followers Gain

Highlights posts that led to the largest increase in followers within 48 hours of publication.  
This helps users understand **which content drives growth and engagement most effectively**.

---

### ⏳ Followers by Account Age

Categorizes followers based on how long they’ve been following:

- **Last 30 Days:** New followers in the past month  
- **1 Month to 1 Year:** Followers acquired between 1 month and 1 year ago  
- **More than 1 Year:** Long-term followers

This segmentation helps in **understanding audience composition and retention over time**.

---

### 🔥 Top Engaged Followers

Identifies the most active followers by counting their **likes on the user’s posts**.  
This shows which followers contribute the most to engagement and interaction, highlighting a user’s core audience.

---

### 📊 Monthly Followers Comparison

Compares follower growth between the last month and the previous month.  
This enables **quick performance assessment** and helps measure improvement or decline in audience acquisition.

---

### Notes

- Provides actionable insights for **content strategy, audience engagement, and growth planning**.  
- Allows users to focus on **top-performing content and high-value followers**.  
- Supports detailed reporting and visualization for **professional-level analytics**.  
- Perfect for platforms emphasizing **social growth, user engagement, and influence tracking**.

_________________________________________________________________________________________________________________________________


## 📊 Post Statistics

The Post Statistics module provides **in-depth analytics on a user’s content performance**.  
It empowers writers and content creators to understand engagement patterns, optimize posting strategies, and measure the impact of their posts.

---

### 🏅 Top Five Posts by Likes

Highlights the **five posts with the highest number of likes**.  
This allows users to quickly see which posts resonate most with their audience.

---

### 📈 Engagement Rate per Post

Calculates the **engagement rate for each post** based on the number of likes relative to the user’s follower count.  
This metric helps creators understand how effectively their content connects with their audience.

---

### ⏰ Best Posting Times

Identifies the **hours of the day when posts receive the most likes**.  
By analyzing user engagement by hour, creators can optimize posting schedules for maximum visibility and interaction.

---

### 📊 Average Likes per Post

Computes the **average number of likes a post receives**.  
Provides a simple benchmark for overall content performance and helps track growth over time.

---

### 🔥 Most Viral Post

Determines which post gained the **highest number of likes within the first 24 hours** after publication.  
This insight reveals which content spreads quickly and generates immediate engagement.

---

### 🔄 Followers Retention Rate

Measures the engagement of **new followers acquired in the last 30 days**.  
Specifically, it calculates how many of these followers interact with the user’s posts through likes.  
This metric helps track **audience loyalty and retention effectiveness**.

---

### Notes

- Offers actionable insights to improve **content strategy and audience engagement**.  
- Helps creators focus on **high-performing content** and optimize posting schedules.  
- Combines multiple metrics (likes, engagement, virality, retention) for a **complete overview**.  
- Perfect for professional content creators, bloggers, and social media influencers who want **detailed performance analytics**.

---

## 📊 Dashboard & Platform Statistics

The Dashboard module provides a **comprehensive overview of the platform’s performance, user activity, and content engagement**.  
It is designed for administrators and managers to monitor key metrics, track growth, and identify top contributors at a glance.

---

### 👥 User Statistics

- **Total Users:** Shows the total number of registered users, excluding admins and editors.  
- **New Users Last 30 Days:** Tracks recently registered users to monitor short-term growth.  
- **Top Users by Followers:** Highlights the most influential users with the highest follower counts.  
- **Monthly & Weekly User Growth Rate:** Measures growth trends over time to evaluate platform expansion and adoption.

---

### 📝 Post Statistics

- **Total Posts:** Counts all posts published on the platform.  
- **Top Users by Posts:** Shows which users contribute the most content.  
- **Top Posts by Likes:** Displays the posts with the highest engagement through likes.  
- **Posts Count by Period:** Tracks post creation trends today, this week, and this month.  
- **Monthly & Weekly Post Growth Rate:** Measures how content production evolves over time.

---

### 🗂 Category Statistics

- **Top Categories by Posts:** Highlights the categories with the most posts to understand content distribution and popularity trends.

---

### 📈 Engagement Analysis

- **Top Hours by Likes:** Shows the hours of the day when posts receive the most likes, helping optimize posting times.  
- **Top Days by Likes:** Displays the days of the week with the highest engagement.  
- **Top Posts by Likes & Users:** Identifies top-performing posts and active contributors to spotlight trending content.

---

### Notes

- Provides **real-time, actionable insights** for administrators to make data-driven decisions.  
- Helps track **platform health, user activity, content engagement, and overall growth**.  
- Ideal for dashboards in **content platforms, social networks, or multi-author blogs**.  
- Combines **user, post, and category analytics** into a single unified view for quick assessment.

_________________________________________________________________________________________________________________________________


## 📊 Dashboard & Platform Statistics

The Dashboard module provides a **comprehensive overview of the platform’s performance, user activity, and content engagement**.  
It is designed for administrators and managers to monitor key metrics, track growth, and identify top contributors at a glance.

---

### 👥 User Statistics

- **Total Users:** Shows the total number of registered users, excluding admins and editors.  
- **New Users Last 30 Days:** Tracks recently registered users to monitor short-term growth.  
- **Top Users by Followers:** Highlights the most influential users with the highest follower counts.  
- **Monthly & Weekly User Growth Rate:** Measures growth trends over time to evaluate platform expansion and adoption.

---

### 📝 Post Statistics

- **Total Posts:** Counts all posts published on the platform.  
- **Top Users by Posts:** Shows which users contribute the most content.  
- **Top Posts by Likes:** Displays the posts with the highest engagement through likes.  
- **Posts Count by Period:** Tracks post creation trends today, this week, and this month.  
- **Monthly & Weekly Post Growth Rate:** Measures how content production evolves over time.

---

### 🗂 Category Statistics

- **Top Categories by Posts:** Highlights the categories with the most posts to understand content distribution and popularity trends.

---

### 📈 Engagement Analysis

- **Top Hours by Likes:** Shows the hours of the day when posts receive the most likes, helping optimize posting times.  
- **Top Days by Likes:** Displays the days of the week with the highest engagement.  
- **Top Posts by Likes & Users:** Identifies top-performing posts and active contributors to spotlight trending content.

---

### Notes

- Provides **real-time, actionable insights** for administrators to make data-driven decisions.  
- Helps track **platform health, user activity, content engagement, and overall growth**.  
- Ideal for dashboards in **content platforms, social networks, or multi-author blogs**.  
- Combines **user, post, and category analytics** into a single unified view for quick assessment.

_________________________________________________________________________________________________________________________________


## 🔔 Notifications

The Notifications module keeps users informed about **important events, updates, and interactions** on the platform.  
It ensures that users never miss relevant actions, such as post approvals, author requests, or content updates.

---

### 📬 Get My Notifications

- Retrieves all notifications for the currently logged-in user.  
- If no notifications exist, a friendly message is returned.  
- Enables users to stay up-to-date with all relevant platform activities.  
- Perfect for real-time engagement and maintaining user awareness.

---

### 👁️ Show Notification

- Allows a user to view a specific notification in detail.  
- Marks the notification as read by updating the `read_at` timestamp.  
- Ensures users can track which notifications they have already seen.  
- Provides a seamless and reliable way to manage notification status.

---

### Notes

- Notifications are tied to user actions, such as post updates, approvals, or author requests.  
- Real-time updates enhance user engagement and awareness.  
- Read/unread tracking ensures clarity and prevents missed information.  
- Designed for both **efficiency and user experience**, supporting large volumes of notifications without performance issues.

_________________________________________________________________________________________________________________________________


## 👤 User Profile Management

The User Profile module allows users to **view and manage their personal information** on the platform.  
It ensures that profiles remain up-to-date and provides a seamless experience for both self-management and public profile viewing.

---

### 📋 Get My Profile

- Retrieves the currently logged-in user’s profile data.  
- Includes essential user information such as first name, last name, and other profile details.  
- Provides a clear snapshot of the user’s personal data.

---

### 🔍 Get User Profile Data

- Allows viewing the profile of any specific user by their ID.  
- Useful for displaying public profiles or accessing other users’ information for social interactions.  
- Returns structured profile data in a clean and readable format.

---

### ✏️ Update Profile

- Enables users to update their first name and last name.  
- Only non-empty fields are updated to preserve existing data.  
- Provides feedback confirming the successful update.  
- Ensures secure and reliable profile modifications.

---

### Notes

- Supports both self-profile management and public profile viewing.  
- Efficiently validates input to avoid accidental overwrites or empty updates.  
- Designed for smooth user experience, maintaining consistency across the platform.  
- Lays the foundation for future profile enhancements like **avatars, bio, or social links**.

_________________________________________________________________________________________________________________________________

## 👥 User Management

The User Management module provides **full control over user administration** within the platform.  
It allows for creating, retrieving, and deleting users, enabling administrators to efficiently manage access and roles.

---

### ➕ Create User

- Registers a new user with **first name, last name, email, and password**.  
- Passwords are securely hashed before storage.  
- Ensures smooth onboarding for new users while maintaining security standards.

---

### 📋 Get Users by Role

- Fetches users filtered by their role: **admin, editor, writer**, or any other assigned role.  
- Allows administrators to quickly access specific groups of users for management purposes.  
- Supports excluding the currently logged-in user from certain queries (e.g., when listing other admins).

---

### ❌ Delete User

- Deletes a specific user from the system.  
- Provides a secure and straightforward method to remove users when necessary.  
- Ensures proper role-based access and prevents accidental deletions.

---

### Notes

- Facilitates complete **user lifecycle management**: creation, retrieval, and removal.  
- Designed for platforms with **role-based access control**. 
- Helps maintain a **clean and organized user base**, ensuring proper platform governance.  
- Ideal for **multi-author content platforms, admin dashboards, or collaborative systems**.
_________________________________________________________________________________________________________________________________