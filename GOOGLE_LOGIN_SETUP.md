# How to Activate Google Login

I have added the **"Sign in with Google"** button to your login page, but it requires a **Client ID** from Google to actually work.

## Step 1: Get a Client ID
1. Go to the [Google Cloud Console](https://console.cloud.google.com/).
2. Create a new project (e.g., "Kismath Web").
3. Search for **"Google Identity Services"** or **"OAuth consent screen"**.
4. Configure the Consent Screen:
    * Select **External**.
    * Fill in App Name ("Kismath"), Support Email, etc.
    * Save and Continue.
5. Go to **Credentials** > **Create Credentials** > **OAuth client ID**.
6. Select Application Type: **Web application**.
7. Add **Authorized JavaScript Origins**:
    * `http://localhost`
    * `http://localhost:8080` (or your specific port)
    * If hosted online, add that URL too (e.g., `http://kismath.infinityfreeapp.com`).
8. Click **Create** and copy the **Client ID** (it looks like `123456...apps.googleusercontent.com`).

## Step 2: Add ID to Your Code
1. Open `login.php`.
2. Find line 89 (approx): `data-client_id="YOUR_GOOGLE_CLIENT_ID"`.
3. Replace `YOUR_GOOGLE_CLIENT_ID` with the real ID you just copied.
4. Save the file.

Now, the Google Login button will work!
