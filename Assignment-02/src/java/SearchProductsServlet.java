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

public class SearchProductsServlet extends HttpServlet {

    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        response.setContentType("text/html");
        response.setCharacterEncoding("UTF-8");
        PrintWriter out = response.getWriter();

        String query = request.getParameter("query");

        out.println("<html><head><title>Search Products</title>");
        out.println("<style>");
        out.println("* { margin: 0; padding: 0; }");
        out.println("header { display: flex; align-items: center; justify-content: space-between; padding: 20px; margin-bottom: 30px; background-color: #ccccf0; }");
        out.println("form { display: flex; flex-direction: column; gap: 20px; margin: auto; width: fit-content; }");
        out.println("label { width: 100px; }");
        out.println("input, button { width: 300px; padding: 10px; border-radius: 10px; border: 1px solid grey; }");
        out.println("button { width: 100px; display: flex; margin: auto; text-align: center; }");
        out.println("table { border-collapse: collapse; width: 70%; margin: auto; }");
        out.println("th, td { padding: 10px; border: 1px solid #ddd; }");
        out.println("main { border: 1px solid gray; border-radius: 10px; width: fit-content; margin: auto; padding: 20px; }");
        out.println("h1 { text-align: center; margin-bottom: 30px; }");
        out.println("</style></head><body>");
        out.println("<header><h1>Product Management</h1><nav><a href='index.html'>Add Product</a> | <a href='ViewProductsServlet'>View Products</a> | <a href='SearchProductsServlet'>Search Products</a></nav></header>");
        out.println("<main><h1>Search Products</h1>");
        

        out.println("<form action='SearchProductsServlet' method='get'>");
        out.println("<div><label>Search:</label>");
        out.println("<input type='text' name='query' required></div>");
        out.println("<button type='submit'>Search</button>");
        out.println("</form>");

        if (query != null && !query.trim().isEmpty()) {
            out.println("<h2>Search Results:</h2>");
            out.println("<table><thead><tr><th>ID</th><th>Name</th><th>Category</th><th>Price</th><th>Stock</th></tr></thead><tbody>");

            try {
                Class.forName("com.mysql.cj.jdbc.Driver");
                Connection conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/product_management", "root", "afrinshah");

                String sql = "SELECT * FROM products WHERE name LIKE ? OR category LIKE ?";
                PreparedStatement ps = conn.prepareStatement(sql);
                ps.setString(1, "%" + query + "%");
                ps.setString(2, "%" + query + "%");
                ResultSet rs = ps.executeQuery();

                while (rs.next()) {
                    int id = rs.getInt("id");
                    String name = rs.getString("name");
                    String category = rs.getString("category");
                    double price = rs.getDouble("price");
                    int stock = rs.getInt("stock");

                    out.println("<tr>");
                    out.println("<td>" + id + "</td>");
                    out.println("<td>" + name + "</td>");
                    out.println("<td>" + category + "</td>");
                    out.println("<td>Rs. " + price + "</td>");
                    out.println("<td>" + stock + "</td>");
                    out.println("</tr>");
                }

                rs.close();
                ps.close();
                conn.close();
            } catch (Exception e) {
                out.println("<tr><td colspan='5'>Error retrieving products.</td></tr>");
            }

            out.println("</tbody></table>");
        }

        out.println("</main></body></html>");
    }
}
