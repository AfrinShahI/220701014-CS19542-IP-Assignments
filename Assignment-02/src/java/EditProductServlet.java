/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/JSP_Servlet/Servlet.java to edit this template
 */

import java.io.*;
import java.sql.*;
import jakarta.servlet.*;
import jakarta.servlet.http.*;


/**
 *
 * @author AFRIN
 */

public class EditProductServlet extends HttpServlet {

    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        response.setContentType("text/html");
        response.setCharacterEncoding("UTF-8");
        PrintWriter out = response.getWriter();

        int productId = Integer.parseInt(request.getParameter("id"));

        try {
            // Connect to the database
            Class.forName("com.mysql.cj.jdbc.Driver");
            Connection conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/product_management", "root", "afrinshah");
            String query = "SELECT * FROM products WHERE id = ?";
            PreparedStatement ps = conn.prepareStatement(query);
            ps.setInt(1, productId);
            ResultSet rs = ps.executeQuery();

            // Apply the same styling to the HTML form
            out.println("<!DOCTYPE html>");
            out.println("<html><head><title>Edit Product</title>");
            out.println("<style>");
            out.println("* { padding: 0; margin: 0; }");
            out.println("header { display: flex; align-items: center; justify-content: space-between; padding: 20px; margin-bottom: 30px; background-color: #ccccf0; }");
            out.println("form { display: flex; flex-direction: column; gap: 30px; }");
            out.println("label { width: 100px; }");
            out.println("input, button { width: 300px; padding: 10px; border-radius: 10px; border: 1px solid grey; }");
            out.println("button { width: 100px; display: flex; margin: auto; text-align: center; }");
            out.println("form div { display: flex; align-items: center; }");
            out.println("main { border: 1px solid gray; border-radius: 10px; width: fit-content; margin: auto; padding: 20px; }");
            out.println("main h1 { text-align: center; margin-bottom: 30px; }");
            out.println("</style>");
            out.println("</head><body>");
            
            out.println("<header>");
            out.println("<h1>Product Management</h1>");
            out.println("<nav>");
            out.println("<a href='index.html'>Add Product</a> | ");
            out.println("<a href='ViewProductsServlet'>View Products</a> | ");
            out.println("<a href='SearchProductsServlet'>Search Products</a>");
            out.println("</nav>");
            out.println("</header>");
            
            if (rs.next()) {
                int id = rs.getInt("id");
                String name = rs.getString("name");
                String category = rs.getString("category");
                double price = rs.getDouble("price");
                int stock = rs.getInt("stock");

                out.println("<main>");
                out.println("<h1>Edit Product</h1>");
                out.println("<form action='EditProductServlet' method='post'>");
                out.println("<input type='hidden' name='id' value='" + id + "'>");
                
                out.println("<div><label>Name:</label>");
                out.println("<input type='text' name='name' value='" + name + "' required></div>");
                
                out.println("<div><label>Category:</label>");
                out.println("<input type='text' name='category' value='" + category + "'></div>");
                
                out.println("<div><label>Price:</label>");
                out.println("<input type='text' name='price' value='" + price + "' required></div>");
                
                out.println("<div><label>Stock:</label>");
                out.println("<input type='number' name='stock' value='" + stock + "' min='1' required></div>");
                
                out.println("<button type='submit'>Update Product</button>");
                out.println("</form>");
                out.println("</main>");
            } else {
                out.println("<h2>Product not found.</h2>");
            }

            out.println("</body></html>");

            rs.close();
            ps.close();
            conn.close();
        } catch (Exception e) {
            out.println("<h2>Error retrieving product details.</h2>");
        }
    }

    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        PrintWriter out = response.getWriter();
        int productId = Integer.parseInt(request.getParameter("id"));
        String name = request.getParameter("name");
        String category = request.getParameter("category");
        double price = Double.parseDouble(request.getParameter("price"));
        int stock = Integer.parseInt(request.getParameter("stock"));

        try {
            // Connect to the database
            Class.forName("com.mysql.cj.jdbc.Driver");
            Connection conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/product_management", "root", "afrinshah");

            // Update the product details
            String query = "UPDATE products SET name = ?, category = ?, price = ?, stock = ? WHERE id = ?";
            PreparedStatement ps = conn.prepareStatement(query);
            ps.setString(1, name);
            ps.setString(2, category);
            ps.setDouble(3, price);
            ps.setInt(4, stock);
            ps.setInt(5, productId);

            int rowsUpdated = ps.executeUpdate();

            // Redirect to the view products page after update
            if (rowsUpdated > 0) {
                response.sendRedirect("ViewProductsServlet");
            } else {
                out.println("<h2>Error updating product.</h2>");
            }

            // Close connections
            ps.close();
            conn.close();
        } catch (Exception e) {
            out.println("<h2>Error updating product.</h2>");
        }
    }
}

