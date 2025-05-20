# Group Categories for BuddyBoss

**Contributors:** James Welbes, AI Botty McBotFace  
**Tags:** BuddyBoss, groups, taxonomy, categories, shortcode  
**Requires at least:** 5.6  
**Tested up to:** 6.5  
**Stable tag:** 1.0.0  
**License:** GPLv2 or later  
**License URI:** https://www.gnu.org/licenses/gpl-2.0.html  

Add a custom taxonomy called **Group Categories** to BuddyBoss groups. This plugin allows site admins to organize groups into hierarchical categories, display categories with featured images, and associate groups with those categories via the admin interface.

---

## 🔧 Features

- Registers a new taxonomy: `Group Category`
- Adds a metabox to the BuddyBoss Group admin edit screen for assigning categories
- Stores selected terms in **group meta**, not as taxonomy terms
- Adds an image upload field for each group category
- Adds a custom archive template to display groups in a selected category
- Includes two shortcodes for frontend display

---

## 🧩 Shortcodes

### 1. `[group_categories]`

Displays a list of group categories assigned to a specific group.

**Attributes:**

- `group_id` *(optional)* — ID of the group. If not specified, uses the current group if viewing a group page.

**Example usage:**

```shortcode
[group_categories group_id="123"]
