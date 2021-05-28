# Custom Metadata Filter
Adds a custom filter for viewing posts with headline metadata. This plugin is a functional version of [this article](https://tommcfarlin.com/custom-link-all-posts-screen).

**Note:** This is meant for demo purposes only.

## Installation
### Using The WordPress Dashboard
1. Navigate to the 'Add New' Plugin Dashboard
2. Select `custom-metadata-filter.zip` from your computer
3. Upload
4. Activate the plugin on the WordPress Plugin Dashboard

### Using FTP
1. Extract `custom-metadata-filter.zip` to your computer
2. Upload the `custom-metadata-filter` directory to your `wp-content/plugins` directory
3. Activate the plugin on the WordPress Plugins Dashboard

### Git

1. Navigate to the `plugins` directory of your WordPress installation.
2. From the terminal, run `$ git clone git@github.com:tommcfarlin/custom-metadata-filter.git`

## Usage

To see how this works, do the following:

1. Open your WordPress database using your preferred MySQL client.
2. Add a row to the `postmeta` table for a post with the `meta_key` set to `article_attribute` and the `meta_value` set to `headline`
3. Navigate to the **All Posts** page to see the change.
4. Modify the `meta_key` or `meta_value` to something else to change the **All Posts** behavior.

## Changes

### 1.0.0 [27-05-2021]
- Initial Release
