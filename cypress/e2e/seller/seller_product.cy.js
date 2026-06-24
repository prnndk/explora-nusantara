describe("Seller Product Management Tests", () => {
  beforeEach(() => {
    cy.loginSeller();
    cy.visit("/dashboard/seller/product");
  });

  it("S9 & S22: Create new product, upload cover image, and check validation", () => {
    cy.contains("Create Product").click();
    cy.url().should("include", "/product/create");

    // Input text details
    cy.get("input[name='product_name']").type("Premium Sumatra Coffee");
    cy.get("select").select("Coffee & Tea");
    cy.get("textarea[placeholder*='message']").type("Organic high-quality Sumatran coffee beans.");
    cy.get("input[name='price']").type("250000");
    cy.get("input[name='stock']").type("50");

    // Upload correct cover image file
    const coverImage = "coffee.jpg";
    cy.get("input[name='foto_file_id']").selectFile("cypress/fixtures/" + coverImage, { force: true });
    cy.contains("Letakkan file disini!").should("not.exist");
    cy.contains(coverImage).should("be.visible");

    // Save product
    cy.contains("button", "Save").click();
    cy.url().should("include", "/dashboard/seller/product");
  });

  it("S10: Edit existing product details", () => {
    // Click on Edit Product pencil-square icon
    cy.get("table").find("tbody tr").first().find("a[href*='product']").click();

    // Modify stock or price
    cy.get("input[name='product_name']").clear().type("Sumatra Coffee Roasted");
    cy.get("input[name='price']").clear().type("275000");
    cy.get("input[name='stock']").clear().type("60");

    // Save
    cy.contains("button", "Save").click();
    cy.url().should("include", "/dashboard/seller/product");
  });

  it("S11: Trigger delete product modal dialog", () => {
    // Click on Delete Product trash icon
    cy.get("table").find("tbody tr").first().find("button").click();
    
    // Assert confirm modal is visible
    cy.contains("Are you sure want to delete this product?").should("be.visible");
    cy.contains("button:visible", "No").click(); // close modal
  });
});
