function delete_news(idx){
  if (confirm('Действительно удалить эту новость?')) jq.get('m_news').remove(idx);
}