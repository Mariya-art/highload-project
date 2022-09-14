FROM rabbitmq:3.8-management-alpine

ENV RABBITMQ_USER highload
ENV RABBITMQ_PASSWORD Y4arhQi3zFvBV5NBdaYmp4RUOmdvL568Xix8loAqoc900bEG5A
ENV RABBITMQ_PID_FILE /var/lib/rabbitmq/mnesia/rabbitmq

ADD init.sh /init.sh
RUN chmod +x /init.sh
EXPOSE 15672

# Define default command
CMD ["/init.sh"]