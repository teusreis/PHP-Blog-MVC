export const deletePost = async (id) => {
    let request = {
        id: id
    };
    const response = await fetch("http://localhost/blog/public/post/delete", {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(request)
    });

    const data = await response.json();

    return data;
}

export const nicknakeExist = async (nickname) => {

    let query = "?nickname=" + nickname;
    let url = "http://localhost/blog/public/nicknakeExist";
    const response = await fetch(url + query);
    const data = await response.json();

    return data;
}

export const emailExist = async (email) => {

    let query = "?email=" + email;
    let url = "http://localhost/blog/public/emailExist";
    const response = await fetch(url + query);
    const data = await response.json();

    return data;
}