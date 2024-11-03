// Data structure to hold blog posts (simulated data)
const blogPostsData = [
    {
        title: 'Blog Post Title 1',
        date: new Date('2024-01-01'),
        category: 'tech',
        content: 'This is a brief description of Blog Post Title 1. It covers the latest trends in technology.',
        reactions: { likes: 0, loves: 0, claps: 0 }
    },
    {
        title: 'Blog Post Title 2',
        date: new Date('2024-01-02'),
        category: 'lifestyle',
        content: 'This is a brief description of Blog Post Title 2. It discusses lifestyle tips and tricks.',
        reactions: { likes: 0, loves: 0, claps: 0 }
    },
    {
        title: 'Blog Post Title 3',
        date: new Date('2024-01-03'),
        category: 'travel',
        content: 'This is a brief description of Blog Post Title 3. It highlights travel experiences and adventures.',
        reactions: { likes: 0, loves: 0, claps: 0 }
    },
    {
        title: 'Blog Post Title 4',
        date: new Date('2024-01-01'),
        category: 'design',
        content: 'This is a brief description of Blog Post Title 4. It showcases various design projects and ideas.',
        reactions: { likes: 0, loves: 0, claps: 0 }
    },
    {
        title: 'Blog Post Title 5',
        date: new Date('2024-01-02'),
        category: 'creative',
        content: 'This is a brief description of Blog Post Title 5. It explores creative processes and innovations.',
        reactions: { likes: 0, loves: 0, claps: 0 }
    },
];

// Function to render blog posts
function renderPosts(posts) {
    const blogPostsContainer = document.getElementById('blogPosts');
    blogPostsContainer.innerHTML = '';

    posts.forEach(post => {
        const postCard = document.createElement('div');
        postCard.className = 'col-md-4';
        postCard.innerHTML = `
            <div class="card mb-4">
                <img src="https://via.placeholder.com/150" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">${post.title}</h5>
                    <p class="card-text">Published on: ${post.date.toDateString()}</p>
                    <p class="card-text">${post.content}</p> <!-- Brief description of the blog -->
                    <div class="reaction-buttons">
                        <button class="btn btn-outline-success" onclick="reactToPost('${post.title}', 'like')">Like (${post.reactions.likes})</button>
                        <button class="btn btn-outline-danger" onclick="reactToPost('${post.title}', 'love')">Love (${post.reactions.loves})</button>
                        <button class="btn btn-outline-warning" onclick="reactToPost('${post.title}', 'clap')">Clap (${post.reactions.claps})</button>
                    </div>
                    <button class="btn btn-primary mt-2">Read More</button>
                    <h6 class="mt-3">Comments:</h6>
                    <div id="comments-${post.title.replace(/\s+/g, '-')}" class="comments-section"></div>
                </div>
            </div>`;
        blogPostsContainer.appendChild(postCard);
    });
}

// Sorting functions
document.getElementById('sortByDate').addEventListener('click', () => {
    const sortedPosts = [...blogPostsData].sort((a, b) => b.date - a.date);
    renderPosts(sortedPosts);
});

document.getElementById('sortByPopularity').addEventListener('click', () => {
    const sortedPosts = [...blogPostsData].sort((a, b) => {
        const totalA = a.reactions.likes + a.reactions.loves + a.reactions.claps;
        const totalB = b.reactions.likes + b.reactions.loves + b.reactions.claps;
        return totalB - totalA; // Sort by total reactions
    });
    renderPosts(sortedPosts);
});

// Filtering function
function filterByCategory(category) {
    const filteredPosts = category === 'all'
        ? blogPostsData
        : blogPostsData.filter(post => post.category === category);

    renderPosts(filteredPosts);
}

// Reaction function
function reactToPost(title, reactionType) {
    const post = blogPostsData.find(post => post.title === title);
    if (post) {
        post.reactions[reactionType + 's'] += 1; // Increment the appropriate reaction
        renderPosts(blogPostsData); // Re-render posts to reflect changes
    }
}

// Comment submission
document.getElementById('commentForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent form submission
    const commentInput = document.getElementById('commentInput').value;
    const postTitle = blogPostsData[0].title; // Get title of the first post for demonstration (modify as needed)

    const commentsSection = document.getElementById(`comments-${postTitle.replace(/\s+/g, '-')}`);
    const commentElement = document.createElement('div');
    commentElement.innerText = commentInput;

    commentsSection.appendChild(commentElement);

    // Alert message
    alert('Your comment has been submitted!');

    // Clear the comment input
    document.getElementById('commentInput').value = '';
});

// Initial rendering of posts
renderPosts(blogPostsData);
